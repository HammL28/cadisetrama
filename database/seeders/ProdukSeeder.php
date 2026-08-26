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
        return [
            // Makanan
            [
                'nama'       => 'Nasi Goreng Special', 
                'jenis'      => 'Makanan', 
                'harga_beli' => 10000, 
                'harga_jual' => 15000, 
                'stok'       => 50,
                'foto'       => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=500&auto=format&fit=crop&q=60'
            ],
            [
                'nama'       => 'Mie Goreng Jawa', 
                'jenis'      => 'Makanan', 
                'harga_beli' => 9000, 
                'harga_jual' => 13000, 
                'stok'       => 40,
                'foto'       => 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=500&auto=format&fit=crop&q=60'
            ],
            [
                'nama'       => 'Roti Tawar Gandum', 
                'jenis'      => 'Makanan', 
                'harga_beli' => 12000, 
                'harga_jual' => 16000, 
                'stok'       => 25,
                'foto'       => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=500&auto=format&fit=crop&q=60'
            ],

            // Minuman
            [
                'nama'       => 'Es Teh Manis', 
                'jenis'      => 'Minuman', 
                'harga_beli' => 2000, 
                'harga_jual' => 5000, 
                'stok'       => 100,
                'foto'       => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=500&auto=format&fit=crop&q=60'
            ],
            [
                'nama'       => 'Kopi Susu Gula Aren', 
                'jenis'      => 'Minuman', 
                'harga_beli' => 8000, 
                'harga_jual' => 18000, 
                'stok'       => 60,
                'foto'       => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=500&auto=format&fit=crop&q=60'
            ],
            [
                'nama'       => 'Air Mineral 600ml', 
                'jenis'      => 'Minuman', 
                'harga_beli' => 1500, 
                'harga_jual' => 4000, 
                'stok'       => 150,
                'foto'       => 'https://images.unsplash.com/photo-1548839140-29a749e1bc4e?w=500&auto=format&fit=crop&q=60'
            ],

            // Snack
            [
                'nama'       => 'Keripik Singkong Pedas', 
                'jenis'      => 'Snack', 
                'harga_beli' => 3000, 
                'harga_jual' => 7000, 
                'stok'       => 5, // Stok kritis untuk uji coba indikator UI
                'foto'       => 'https://images.unsplash.com/photo-1566478989037-eec170784d0b?w=500&auto=format&fit=crop&q=60'
            ],
            [
                'nama'       => 'Wafer Cokelat 125g', 
                'jenis'      => 'Snack', 
                'harga_beli' => 5000, 
                'harga_jual' => 9500, 
                'stok'       => 30,
                'foto'       => 'https://images.unsplash.com/photo-1590080875515-8a3a8dc5735e?w=500&auto=format&fit=crop&q=60'
            ],

            // Sembako & Dapur
            [
                'nama'       => 'Minyak Goreng 1L', 
                'jenis'      => 'Makanan', 
                'harga_beli' => 14000, 
                'harga_jual' => 17500, 
                'stok'       => 80,
                'foto'       => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=500&auto=format&fit=crop&q=60'
            ],

            // ATK
            [
                'nama'       => 'Buku Tulis A5 (10 Pcs)', 
                'jenis'      => 'ATK', 
                'harga_beli' => 25000, 
                'harga_jual' => 38000, 
                'stok'       => 20,
                'foto'       => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop&q=60'
            ],
            [
                'nama'       => 'Pulpen Gel Hitam 0.5mm', 
                'jenis'      => 'ATK', 
                'harga_beli' => 2000, 
                'harga_jual' => 4500, 
                'stok'       => 0, // Stok habis untuk uji coba indikator UI
                'foto'       => 'https://images.unsplash.com/photo-1585336261026-8f5786372966?w=500&auto=format&fit=crop&q=60'
            ],

            // Elektronik
            [
                'nama'       => 'Kabel Data Type-C', 
                'jenis'      => 'Elektronik', 
                'harga_beli' => 15000, 
                'harga_jual' => 30000, 
                'stok'       => 25,
                'foto'       => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=500&auto=format&fit=crop&q=60'
            ],
            [
                'nama'       => 'Headset Bluetooth', 
                'jenis'      => 'Elektronik', 
                'harga_beli' => 45000, 
                'harga_jual' => 85000, 
                'stok'       => 15,
                'foto'       => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=60'
            ],
        ];
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