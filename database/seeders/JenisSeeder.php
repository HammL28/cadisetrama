<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua daftar produk dari ProdukSeeder
        $produkList = ProdukSeeder::getProdukList();

        // Ambil jenis unik dari daftar produk
        $categories = collect($produkList)->pluck('jenis')->unique();

        foreach ($categories as $namaJenis) {
            Jenis::firstOrCreate([
                'nama' => $namaJenis,
            ]);
        }
    }
}