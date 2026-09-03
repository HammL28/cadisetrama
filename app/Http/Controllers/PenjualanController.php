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

        // Query Utama: Mengambil seluruh riwayat transaksi
        $query = Penjualan::query()
            ->with(['user', 'itemPenjualan.produk'])
            // 🔎 Search Fleksibel: ID Transaksi, Nama Kasir, atau Nama Produk
            ->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($sub) use ($keyword) {
                    $sub->where('id', 'like', '%' . $keyword . '%')
                        ->orWhereHas('user', function ($u) use ($keyword) {
                            $u->where('name', 'like', '%' . $keyword . '%');
                        })
                        ->orWhereHas('itemPenjualan.produk', function ($p) use ($keyword) {
                            $p->where('nama', 'like', '%' . $keyword . '%')
                              ->orWhere('nama_produk', 'like', '%' . $keyword . '%');
                        });
                });
            })
            // 🔍 Filter Status
            ->when($status, function ($q) use ($status) {
                $q->whereRaw('LOWER(status) = ?', [strtolower($status)]);
            })
            // 🔍 Filter Metode Pembayaran
            ->when($metode, function ($q) use ($metode) {
                $q->where('metode_pembayaran', 'like', '%' . $metode . '%');
            });

        // Hitung Ringkasan Data (Summary Card)
        $totalOmset = (clone $query)->sum('total_pembayaran');
        $totalNonTunai = (clone $query)->whereIn(DB::raw('LOWER(metode_pembayaran)'), ['qris', 'transfer'])->count();
        $totalTunai = (clone $query)->whereIn(DB::raw('LOWER(metode_pembayaran)'), ['tunai', 'cash'])->count();

        // Dapatkan data paginasi
        $sales = $query->latest()->paginate(10)->withQueryString();

        return view('penjualan.index', compact('sales', 'totalOmset', 'totalNonTunai', 'totalTunai'));
    }

    /**
     * Menampilkan detail transaksi penjualan.
     */
    public function show(Penjualan $penjualan)
    {
        $penjualan->load(['itemPenjualan.produk', 'user']);

        return view('penjualan.show', compact('penjualan'));
    }

    /**
     * Menampilkan halaman kasir (POS) untuk transaksi baru.
     */
    public function create(SearchRequest $request)
    {
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

        $products = Produk::when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', '%' . $keyword . '%')
                  ->orWhere('nama_produk', 'like', '%' . $keyword . '%');
        })
        ->orderBy('nama')
        ->get();

        $mode = 'create';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Membuka halaman POS untuk mengedit transaksi OPEN.
     */
    public function edit(Penjualan $penjualan)
    {
        $sale = $penjualan;

        abort_if(strtoupper($sale->status) === 'COMPLETED', 403, 'Transaksi yang sudah selesai tidak dapat diubah.');

        $sale->load('itemPenjualan.produk');
        $products = Produk::orderBy('nama')->get();
        $mode = 'edit';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Menyelesaikan / Checkout transaksi.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'payment_method' => 'required|in:CASH,QRIS,TRANSFER'
        ]);

        if (strtoupper($penjualan->status) !== 'OPEN') {
            return back()->with('errors', 'Transaksi sudah diproses sebelumnya.');
        }

        if ($penjualan->itemPenjualan()->count() === 0) {
            return back()->with('errors', 'Keranjang belanja masih kosong.');
        }

        DB::transaction(function () use ($penjualan, $request) {
            $total = $penjualan->itemPenjualan()->sum('subtotal');

            $penjualan->update([
                'metode_pembayaran' => $request->payment_method,
                'total_pembayaran'  => $total,
                'status'            => 'COMPLETED',
            ]);

            // 🔴 PERBAIKAN UTAMA: Eager-load relasi produk dan user secara eksplisit
            $penjualan->load(['itemPenjualan.produk', 'user']);

            $currentUser = Auth::user();
            $userName = $currentUser->name ?? 'Kasir';
            $userRole = ucfirst(is_object($currentUser->role) ? ($currentUser->role->name ?? 'User') : ($currentUser->role ?? 'User'));

            $users = User::where('sales_notifications', true)->get();
            foreach ($users as $user) {
                $user->notify(new SaleNotification($penjualan, $total, $userName, $userRole));
            }
        });

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil diselesaikan.');
    }

    /**
     * Membatalkan transaksi OPEN dan mengembalikan stok.
     */
    public function destroy(Penjualan $penjualan)
    {
        if (strtoupper($penjualan->status) !== 'OPEN') {
            return redirect()->route('penjualan.index')
                ->with('errors', 'Transaksi yang sudah selesai tidak dapat dibatalkan.');
        }

        DB::transaction(function () use ($penjualan) {
            foreach ($penjualan->itemPenjualan as $item) {
                if ($item->produk) {
                    $item->produk->increment('stok', $item->kuantitas);
                }
            }

            $penjualan->itemPenjualan()->delete();
            $penjualan->delete();
        });

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }
}