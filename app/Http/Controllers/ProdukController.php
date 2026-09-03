<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Models\Jenis;
use App\Models\Produk;
use App\Models\User;
use App\Notifications\StockNotification;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Produk::class);

        $query = Produk::query();

        // 1. Filter Pencarian
        if ($request->filled('search')) {
            $keyword = $request->input('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                  ->orWhere('jenis', 'like', '%' . $keyword . '%');
            });
        }

        // 2. Filter Jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->input('jenis'));
        }

        // 3. Filter Status Stok
        if ($request->filled('stok_status')) {
            $stokStatus = $request->input('stok_status');
            if ($stokStatus === 'ready') {
                $query->where('stok', '>', 10);
            } elseif ($stokStatus === 'kritis') {
                $query->whereBetween('stok', [1, 10]);
            } elseif ($stokStatus === 'habis') {
                $query->where('stok', 0);
            }
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        $categories = Produk::select('jenis')
            ->whereNotNull('jenis')
            ->distinct()
            ->pluck('jenis');

        return view('produk.index', compact('products', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', Produk::class);
        $jenisList = Jenis::all();

        return view('produk.create', compact('jenisList'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Produk::class);
        $dataReq = $request->validated();

        $data = [
            'user_id'    => Auth::id(),
            'jenis'      => $dataReq['jenis'],
            'nama'       => $dataReq['name'],
            'harga_beli' => $dataReq['purchase_price'],
            'harga_jual' => $dataReq['selling_price'],
            'stok'       => $dataReq['stock'],
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk = Produk::create($data);

        // Pemicu Notifikasi Stok Kritis saat Produk Dibuat
        $this->checkAndSendStockNotification($produk);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $produk)
    {
        $this->authorize('view', $produk);

        return view('produk.detail', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);
        $jenisList = Jenis::all();

        return view('produk.edit', compact('produk', 'jenisList'));
    }

    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);
        $dataReq = $request->validated();

        $data = [
            'user_id'    => Auth::id(),
            'jenis'      => $dataReq['jenis'],
            'nama'       => $dataReq['name'],
            'harga_beli' => $dataReq['purchase_price'],
            'harga_jual' => $dataReq['selling_price'],
            'stok'       => $dataReq['stock'],
        ];

        if ($request->hasFile('foto')) {
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        // Pemicu Notifikasi Stok Kritis saat Produk Diperbarui
        $this->checkAndSendStockNotification($produk);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);

        try {
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            $produk->delete();

            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('produk.index')->with('error', 'Produk gagal dihapus karena sudah tercatat dalam riwayat penjualan.');
            }

            return redirect()->route('produk.index')->with('error', 'Terjadi kesalahan saat menghapus produk.');
        }
    }

    /**
     * Helper privat untuk mengecek dan mengirimkan notifikasi stok kritis.
     */
    private function checkAndSendStockNotification(Produk $produk): void
    {
        // Pemicu aktif jika stok <= 10 (termasuk stok 0)
        if ($produk->stok <= 10) {
            $users = User::where('stock_notifications', true)->get();

            // Fallback: Jika tidak ada user dengan flag khusus, kirim ke semua user
            if ($users->isEmpty()) {
                $users = User::all();
            }

            foreach ($users as $user) {
                Log::info('Sending stock notification to user ID: ' . $user->id);
                $user->notify(new StockNotification($produk, $produk->stok));
            }
        }
    }
}