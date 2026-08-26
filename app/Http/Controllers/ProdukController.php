<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Jenis;
use App\Models\Produk;
use App\Notifications\StockNotification;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Produk::class);

        $query = Produk::query();

        // 1. Filter Pencarian (Search Keyword)
        if ($request->filled('search')) {
            $keyword = $request->input('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                  ->orWhere('jenis', 'like', '%' . $keyword . '%');
            });
        }

        // 2. Filter Kategori / Jenis Produk
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

        // Ambil data produk paginated
        $products = $query->latest()->paginate(10)->withQueryString();

        // AMBIL SEMUA JENIS DARI DATABASE (secara dinamis dari tabel Produk/Jenis)
        $semua_jenis = Produk::select('jenis')
            ->whereNotNull('jenis')
            ->distinct()
            ->pluck('jenis');

        return view('produk.index', compact('products', 'semua_jenis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Produk::class);

        $jenisList = Jenis::all();

        return view('produk.create', compact('jenisList'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        Produk::create($data);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        $this->authorize('view', $produk);

        return view('produk.detail', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);

        $jenisList = Jenis::all();

        return view('produk.edit', compact('produk', 'jenisList'));
    }

    /**
     * Update the specified resource in storage.
     */
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

        // 📬 Kirim notifikasi stok jika stok menipis (< 10)
        if ($data['stok'] < 10 && $data['stok'] > 0) {
            $users = \App\Models\User::where('stock_notifications', true)->get();
            foreach ($users as $user) {
                Log::info('Sending stock notification to user: ' . $user->id . ' - ' . $user->name);
                $user->notify(new StockNotification($produk, $data['stok']));
            }
        }

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);

        try {
            // Hapus foto jika ada di storage
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            // Coba hapus data produk
            $produk->delete();

            return redirect()
                ->route('produk.index')
                ->with('success', 'Produk berhasil dihapus.');

        } catch (QueryException $e) {
            // Tangkap error relasi foreign key constraint (SQLSTATE 23000)
            if ($e->getCode() === '23000') {
                return redirect()
                    ->route('produk.index')
                    ->with('error', 'Produk gagal dihapus karena sudah tercatat dalam riwayat penjualan.');
            }

            return redirect()
                ->route('produk.index')
                ->with('error', 'Terjadi kesalahan saat menghapus produk.');
        }
    }
}