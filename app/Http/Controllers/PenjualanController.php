<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;
use App\Notifications\SaleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class PenjualanController extends Controller
{
    /**
     * Menampilkan daftar transaksi penjualan.
     */
    public function index(SearchRequest $request)
    {
        $keyword = $request->input('search');
        $status = $request->input('status');
        $metode = $request->input('metode');

        // Query utama: mengambil seluruh riwayat transaksi
        $query = Penjualan::query()
            ->with([
                'user',
                'itemPenjualan.produk'
            ])

            // 🔎 Search: ID transaksi, nama kasir, atau nama produk
            ->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($sub) use ($keyword) {
                    $sub->where('id', 'like', '%' . $keyword . '%')
                        ->orWhereHas('user', function ($u) use ($keyword) {
                            $u->where('name', 'like', '%' . $keyword . '%');
                        })
                        ->orWhereHas('itemPenjualan.produk', function ($p) use ($keyword) {
                            $p->where('nama', 'like', '%' . $keyword . '%');
                        });
                });
            })

            // 🔍 Filter status transaksi
            ->when($status, function ($q) use ($status) {
                $q->whereRaw('LOWER(status) = ?', [strtolower($status)]);
            })

            // 🔍 Filter metode pembayaran
            ->when($metode, function ($q) use ($metode) {
                $q->where('metode_pembayaran', 'like', '%' . $metode . '%');
            });

        // ==========================================
        // RINGKASAN DATA
        // ==========================================

        // Total omset (Hanya dari transaksi COMPLETED)
        $totalOmset = (clone $query)
            ->whereRaw('LOWER(status) = ?', ['completed'])
            ->sum('total_pembayaran');

        // Total transaksi non-tunai
        $totalNonTunai = (clone $query)
            ->whereIn(DB::raw('LOWER(metode_pembayaran)'), ['qris', 'transfer'])
            ->count();

        // Total transaksi tunai
        $totalTunai = (clone $query)
            ->whereIn(DB::raw('LOWER(metode_pembayaran)'), ['tunai', 'cash'])
            ->count();

        // ==========================================
        // PAGINATION
        // ==========================================

        $sales = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('penjualan.index', compact(
            'sales',
            'totalOmset',
            'totalNonTunai',
            'totalTunai'
        ));
    }

    /**
     * Menampilkan detail transaksi penjualan.
     */
    public function show(Penjualan $penjualan)
    {
        $penjualan->load([
            'itemPenjualan.produk',
            'user'
        ]);

        return view('penjualan.show', compact('penjualan'));
    }

    /**
     * Menampilkan halaman kasir (POS) untuk membuat transaksi baru.
     */
    public function create(SearchRequest $request)
    {
        // Membuat atau mengambil transaksi OPEN milik user yang sedang login
        $sale = Penjualan::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status'  => 'OPEN'
            ],
            [
                'total_pembayaran'  => 0,
                'metode_pembayaran' => 'CASH'
            ]
        );

        $keyword = $request->input('search');

        // PENCARIAN PRODUK
        $products = Produk::when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', '%' . $keyword . '%');
        })
        ->orderBy('nama')
        ->get();

        // Data user (dipakai untuk nomor rekening bank di modal transfer)
        $user = Auth::user();

        $mode = 'create';

        return view('penjualan.pos', compact('sale', 'products', 'mode', 'user'));
    }

    /**
     * Membuka halaman POS untuk mengedit transaksi OPEN.
     */
    public function edit(Penjualan $penjualan)
    {
        $sale = $penjualan;

        // Transaksi COMPLETED tidak boleh diedit
        abort_if(
            strtoupper($sale->status) === 'COMPLETED',
            403,
            'Transaksi yang sudah selesai tidak dapat diubah.'
        );

        $sale->load('itemPenjualan.produk');
        $products = Produk::orderBy('nama')->get();

        // Data user (dipakai untuk nomor rekening bank di modal transfer)
        $user = Auth::user();

        $mode = 'edit';

        return view('penjualan.pos', compact('sale', 'products', 'mode', 'user'));
    }

    /**
     * Menyelesaikan / checkout transaksi.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        // Validasi metode pembayaran
        $request->validate([
            'payment_method' => 'required|in:CASH,QRIS,TRANSFER'
        ]);

        // Pastikan transaksi masih OPEN
        if (strtoupper($penjualan->status) !== 'OPEN') {
            return back()->with('error', 'Transaksi sudah diproses sebelumnya.');
        }

        // Pastikan keranjang tidak kosong
        if ($penjualan->itemPenjualan()->count() === 0) {
            return back()->with('error', 'Keranjang belanja masih kosong.');
        }

        try {
            DB::transaction(function () use ($penjualan, $request) {
                $penjualan->load('itemPenjualan.produk');

                // 1. Cek ketersediaan stok & kurangi stok
                foreach ($penjualan->itemPenjualan as $item) {
                    // Lock record produk untuk mencegah race condition
                    $produk = Produk::where('id', $item->produk_id)->lockForUpdate()->first();

                    if (!$produk || $produk->stok < $item->kuantitas) {
                        throw new Exception("Stok untuk produk '{$item->produk->nama}' tidak mencukupi.");
                    }

                    // Kurangi stok produk
                    $produk->decrement('stok', $item->kuantitas);
                }

                // 2. Hitung total transaksi
                $total = $penjualan->itemPenjualan()->sum('subtotal');

                // 3. Update status transaksi
                $penjualan->update([
                    'metode_pembayaran' => $request->payment_method,
                    'total_pembayaran'  => $total,
                    'status'            => 'COMPLETED',
                ]);

                // 4. Kirim Notifikasi Penjualan
                $currentUser = Auth::user();
                $userName = $currentUser->name ?? 'Kasir';
                $userRole = ucfirst(
                    is_object($currentUser->role)
                        ? ($currentUser->role->name ?? 'User')
                        : ($currentUser->role ?? 'User')
                );

                $usersToNotify = User::where('sales_notifications', true)->get();

                foreach ($usersToNotify as $user) {
                    $user->notify(new SaleNotification(
                        $penjualan,
                        $total,
                        $userName,
                        $userRole
                    ));
                }
            });
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil diselesaikan.');
    }

    /**
     * Membatalkan transaksi OPEN.
     */
    public function destroy(Penjualan $penjualan)
    {
        // Transaksi COMPLETED tidak boleh dibatalkan lewat fungsi ini
        if (strtoupper($penjualan->status) !== 'OPEN') {
            return redirect()
                ->route('penjualan.index')
                ->with('error', 'Transaksi yang sudah selesai tidak dapat dibatalkan.');
        }

        DB::transaction(function () use ($penjualan) {
            // Hapus relasi item transaksi dan data transaksi utama
            $penjualan->itemPenjualan()->delete();
            $penjualan->delete();
        });

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }
}