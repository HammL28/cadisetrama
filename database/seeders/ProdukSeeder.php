<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Data master produk yang digunakan juga oleh JenisSeeder
     */
    public static function getProdukList(): array
    {
        // Mengembalikan array kosong agar tidak ada produk yang dibuat
        return [];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID user pertama yang ada di database agar aman dari error FK
        $user = User::first();
        $userId = $user ? $user->id : 1;

        $produkList = self::getProdukList();

        foreach ($produkList as $item) {
            Produk::create([
                'user_id'    => $userId,
                'jenis'      => $item['jenis'],
                'nama'       => $item['nama'],
                'harga_beli' => $item['harga_beli'],
                'harga_jual' => $item['harga_jual'],
                'stok'       => $item['stok'],
                'foto'       => $item['foto'],
            ]);
        }
    }
}