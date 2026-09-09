<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ItemPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        try {
            DB::transaction(function () use ($request) {

                $sale = Penjualan::where('user_id', Auth::id())
                    ->where('status', 'OPEN')
                    ->firstOrFail();

                $product = Produk::lockForUpdate()->findOrFail($request->product_id);

                // Cek ketersediaan stok
                if ($product->stok < $request->quantity) {
                    throw ValidationException::withMessages([
                        'stok' => 'Stok produk ' . $product->nama . ' tidak mencukupi.'
                    ]);
                }

                // Kurangi stok produk
                $product->decrement('stok', $request->quantity);

                // Update / Insert item penjualan
                $item = ItemPenjualan::where('penjualan_id', $sale->id)
                    ->where('produk_id', $product->id)
                    ->lockForUpdate()
                    ->first();

                if ($item) {
                    // UPDATE
                    $item->kuantitas += $request->quantity;
                } else {
                    // CREATE
                    $item = new ItemPenjualan([
                        'penjualan_id' => $sale->id,
                        'produk_id'    => $product->id,
                        'kuantitas'    => $request->quantity,
                        'harga_satuan' => $product->harga_jual,
                    ]);
                }

                // Hitung subtotal setelah kuantitas pasti
                $item->subtotal = $item->kuantitas * $item->harga_satuan;
                $item->save();

                // Recalculate total pembayaran
                $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
                $sale->save();
            });

            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');

        } catch (ValidationException $e) {
            return back()->with('errors', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('errors', 'Terjadi kesalahan saat menambahkan barang.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        try {
            DB::transaction(function () use ($request, $itempenjualan) {

                // Tentukan kuantitas baru berdasarkan aksi tombol (+/-) atau input manual
                $newQuantity = $itempenjualan->kuantitas;

                if ($request->has('action')) {
                    if ($request->action === 'increase') {
                        $newQuantity += 1;
                    } elseif ($request->action === 'decrease') {
                        $newQuantity = max(1, $newQuantity - 1);
                    }
                } elseif ($request->has('quantity')) {
                    $request->validate([
                        'quantity' => 'required|integer|min:1'
                    ]);
                    $newQuantity = (int) $request->quantity;
                }

                $selisih = $newQuantity - $itempenjualan->kuantitas;

                if ($selisih === 0) {
                    return;
                }

                $produk = $itempenjualan->produk()->lockForUpdate()->first();

                // Jika qty bertambah = kurangi stok produk
                if ($selisih > 0) {
                    if ($produk->stok < $selisih) {
                        throw ValidationException::withMessages([
                            'stok' => 'Stok produk ' . $produk->nama . ' tidak mencukupi.'
                        ]);
                    }
                    $produk->decrement('stok', $selisih);
                }

                // Jika qty berkurang = kembalikan stok produk
                if ($selisih < 0) {
                    $produk->increment('stok', abs($selisih));
                }

                // Update item penjualan
                $itempenjualan->update([
                    'kuantitas' => $newQuantity,
                    'subtotal'  => $newQuantity * $itempenjualan->harga_satuan
                ]);

                // Update total pembayaran di tabel penjualan
                $sale = $itempenjualan->penjualan;
                $sale->update([
                    'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
                ]);
            });

            return back();

        } catch (ValidationException $e) {
            return back()->with('errors', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('errors', 'Gagal memperbarui jumlah barang.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemPenjualan $itempenjualan)
    {
        $this->authorize('delete', $itempenjualan);

        try {
            DB::transaction(function () use ($itempenjualan) {

                $produk = $itempenjualan->produk()->lockForUpdate()->first();
                $sale   = $itempenjualan->penjualan;

                // Kembalikan stok sesuai kuantitas item
                if ($produk) {
                    $produk->increment('stok', $itempenjualan->kuantitas);
                }

                // Hapus item dari keranjang
                $itempenjualan->delete();

                // Recalculate total penjualan
                $sale->update([
                    'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
                ]);
            });

            return back()->with('success', 'Item berhasil dihapus dari keranjang.');

        } catch (\Exception $e) {
            return back()->with('errors', 'Gagal menghapus item.');
        }
    }
}