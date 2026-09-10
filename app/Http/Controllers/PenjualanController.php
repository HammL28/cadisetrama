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

            // 🔎 Search:
            // - ID transaksi
            // - Nama kasir
            // - Nama produk
            ->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($sub) use ($keyword) {

                    // Cari berdasarkan ID transaksi
                    $sub->where('id', 'like', '%' . $keyword . '%')

                        // Cari berdasarkan nama kasir
                        ->orWhereHas('user', function ($u) use ($keyword) {
                            $u->where(
                                'name',
                                'like',
                                '%' . $keyword . '%'
                            );
                        })

                        // Cari berdasarkan nama produk
                        ->orWhereHas('itemPenjualan.produk', function ($p) use ($keyword) {
                            $p->where(
                                'nama',
                                'like',
                                '%' . $keyword . '%'
                            );
                        });
                });
            })

            // 🔍 Filter status transaksi
            ->when($status, function ($q) use ($status) {
                $q->whereRaw(
                    'LOWER(status) = ?',
                    [strtolower($status)]
                );
            })

            // 🔍 Filter metode pembayaran
            ->when($metode, function ($q) use ($metode) {
                $q->where(
                    'metode_pembayaran',
                    'like',
                    '%' . $metode . '%'
                );
            });

        // ==========================================
        // RINGKASAN DATA
        // ==========================================

        // Total omset
        $totalOmset = (clone $query)
            ->sum('total_pembayaran');

        // Total transaksi non-tunai
        $totalNonTunai = (clone $query)
            ->whereIn(
                DB::raw('LOWER(metode_pembayaran)'),
                ['qris', 'transfer']
            )
            ->count();

        // Total transaksi tunai
        $totalTunai = (clone $query)
            ->whereIn(
                DB::raw('LOWER(metode_pembayaran)'),
                ['tunai', 'cash']
            )
            ->count();

        // ==========================================
        // PAGINATION
        // ==========================================

        $sales = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'penjualan.index',
            compact(
                'sales',
                'totalOmset',
                'totalNonTunai',
                'totalTunai'
            )
        );
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

        return view(
            'penjualan.show',
            compact('penjualan')
        );
    }

    /**
     * Menampilkan halaman kasir (POS)
     * untuk membuat transaksi baru.
     */
    public function create(SearchRequest $request)
    {
        // Membuat atau mengambil transaksi OPEN
        // milik user yang sedang login.
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

        // ==========================================
        // PENCARIAN PRODUK
        // ==========================================
        // Kolom yang digunakan adalah "nama".
        // Tidak menggunakan "nama_produk".
        $products = Produk::when($keyword, function ($query) use ($keyword) {
            $query->where(
                'nama',
                'like',
                '%' . $keyword . '%'
            );
        })
        ->orderBy('nama')
        ->get();

        $mode = 'create';

        return view(
            'penjualan.pos',
            compact(
                'sale',
                'products',
                'mode'
            )
        );
    }

    /**
     * Membuka halaman POS untuk
     * mengedit transaksi OPEN.
     */
    public function edit(Penjualan $penjualan)
    {
        $sale = $penjualan;

        // Transaksi COMPLETED tidak boleh diedit.
        abort_if(
            strtoupper($sale->status) === 'COMPLETED',
            403,
            'Transaksi yang sudah selesai tidak dapat diubah.'
        );

        // Load item dan produk
        $sale->load('itemPenjualan.produk');

        // Ambil seluruh produk
        $products = Produk::orderBy('nama')->get();

        $mode = 'edit';

        return view(
            'penjualan.pos',
            compact(
                'sale',
                'products',
                'mode'
            )
        );
    }

    /**
     * Menyelesaikan / checkout transaksi.
     */
    public function update(
        Request $request,
        Penjualan $penjualan
    ) {
        // Validasi metode pembayaran
        $request->validate([
            'payment_method' => 'required|in:CASH,QRIS,TRANSFER'
        ]);

        // Pastikan transaksi masih OPEN
        if (strtoupper($penjualan->status) !== 'OPEN') {
            return back()->with(
                'errors',
                'Transaksi sudah diproses sebelumnya.'
            );
        }

        // Pastikan keranjang tidak kosong
        if ($penjualan->itemPenjualan()->count() === 0) {
            return back()->with(
                'errors',
                'Keranjang belanja masih kosong.'
            );
        }

        DB::transaction(function () use (
            $penjualan,
            $request
        ) {
            // Hitung total transaksi
            $total = $penjualan
                ->itemPenjualan()
                ->sum('subtotal');

            // Update transaksi
            $penjualan->update([
                'metode_pembayaran' => $request->payment_method,
                'total_pembayaran'  => $total,
                'status'            => 'COMPLETED',
            ]);

            // Load relasi produk dan user
            $penjualan->load([
                'itemPenjualan.produk',
                'user'
            ]);

            // ==========================================
            // NOTIFIKASI
            // ==========================================

            $currentUser = Auth::user();

            $userName = $currentUser->name ?? 'Kasir';

            $userRole = ucfirst(
                is_object($currentUser->role)
                    ? ($currentUser->role->name ?? 'User')
                    : ($currentUser->role ?? 'User')
            );

            // Ambil user yang mengaktifkan notifikasi penjualan
            $users = User::where(
                'sales_notifications',
                true
            )->get();

            foreach ($users as $user) {
                $user->notify(
                    new SaleNotification(
                        $penjualan,
                        $total,
                        $userName,
                        $userRole
                    )
                );
            }
        });

        return redirect()
            ->route('penjualan.index')
            ->with(
                'success',
                'Transaksi berhasil diselesaikan.'
            );
    }

    /**
     * Membatalkan transaksi OPEN
     * dan mengembalikan stok produk.
     */
    public function destroy(Penjualan $penjualan)
    {
        // Transaksi yang sudah selesai
        // tidak boleh dibatalkan.
        if (strtoupper($penjualan->status) !== 'OPEN') {
            return redirect()
                ->route('penjualan.index')
                ->with(
                    'errors',
                    'Transaksi yang sudah selesai tidak dapat dibatalkan.'
                );
        }

        DB::transaction(function () use ($penjualan) {

            // Load item penjualan
            $penjualan->load('itemPenjualan.produk');

            // Kembalikan stok
            foreach ($penjualan->itemPenjualan as $item) {

                if ($item->produk) {
                    $item->produk->increment(
                        'stok',
                        $item->kuantitas
                    );
                }
            }

            // Hapus item transaksi
            $penjualan->itemPenjualan()->delete();

            // Hapus transaksi
            $penjualan->delete();
        });

        return redirect()
            ->route('penjualan.index')
            ->with(
                'success',
                'Transaksi berhasil dibatalkan.'
            );
    }
}
