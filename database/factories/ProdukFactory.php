<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Kamus data produk realistis + Gambar Unsplash
        $daftarProduk = [
            'Makanan' => [
                [
                    'nama' => 'Nasi Goreng Spesial', 
                    'harga_beli' => 12000, 
                    'harga_jual' => 18000,
                    'foto' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=400&auto=format&fit=crop&q=80'
                ],
                [
                    'nama' => 'Mie Goreng Jawa', 
                    'harga_beli' => 10000, 
                    'harga_jual' => 15000,
                    'foto' => 'https://images.unsplash.com/photo-1612927601601-6638404737ce?w=400&auto=format&fit=crop&q=80'
                ],
                [
                    'nama' => 'Ayam Bakar Madu', 
                    'harga_beli' => 15000, 
                    'harga_jual' => 22000,
                    'foto' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=400&auto=format&fit=crop&q=80'
                ],
            ],
            'Minuman' => [
                [
                    'nama' => 'Kopi Susu Gula Aren', 
                    'harga_beli' => 10000, 
                    'harga_jual' => 18000,
                    'foto' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=400&auto=format&fit=crop&q=80'
                ],
                [
                    'nama' => 'Teh Tarik Boba', 
                    'harga_beli' => 8000, 
                    'harga_jual' => 15000,
                    'foto' => 'https://images.unsplash.com/photo-1558857563-b371033873b8?w=400&auto=format&fit=crop&q=80'
                ],
                [
                    'nama' => 'Jus Alpukat', 
                    'harga_beli' => 8000, 
                    'harga_jual' => 13000,
                    'foto' => 'https://images.unsplash.com/photo-1553530666-ba11a7da3888?w=400&auto=format&fit=crop&q=80'
                ],
            ],
            'Snack' => [
                [
                    'nama' => 'Keripik Singkong Pedas', 
                    'harga_beli' => 7000, 
                    'harga_jual' => 12000,
                    'foto' => 'https://images.unsplash.com/photo-1566478989037-eec170784d0b?w=400&auto=format&fit=crop&q=80'
                ],
                [
                    'nama' => 'Cokelat Batangan 50g', 
                    'harga_beli' => 8000, 
                    'harga_jual' => 12500,
                    'foto' => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=400&auto=format&fit=crop&q=80'
                ],
            ],
            'Elektronik' => [
                [
                    'nama' => 'Mouse Wireless Ergonomis', 
                    'harga_beli' => 60000, 
                    'harga_jual' => 85000,
                    'foto' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=400&auto=format&fit=crop&q=80'
                ],
                [
                    'nama' => 'Keyboard Mechanical RGB', 
                    'harga_beli' => 180000, 
                    'harga_jual' => 250000,
                    'foto' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&auto=format&fit=crop&q=80'
                ],
            ],
            'ATK' => [
                [
                    'nama' => 'Buku Tulis A5 50 Lembar', 
                    'harga_beli' => 4500, 
                    'harga_jual' => 7000,
                    'foto' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&auto=format&fit=crop&q=80'
                ],
                [
                    'nama' => 'Pensil & Alat Tulis Set', 
                    'harga_beli' => 12000, 
                    'harga_jual' => 18000,
                    'foto' => 'https://images.unsplash.com/photo-1585336261026-8f5786372966?w=400&auto=format&fit=crop&q=80'
                ],
            ],
        ];

        // Acak jenis/kategori
        $jenis = fake()->randomElement(['Makanan', 'Minuman', 'Snack', 'Elektronik', 'ATK']);

        // Ambil item produk yang sesuai dengan kategori
        $item = fake()->randomElement($daftarProduk[$jenis]);

        return [
            'user_id'    => User::where('role_id', 1)->inRandomOrder()->value('id') ?? User::first()->id ?? 1,
            'jenis'      => $jenis,
            'nama'       => $item['nama'],
            'harga_beli' => $item['harga_beli'],
            'harga_jual' => $item['harga_jual'],
            'stok'       => fake()->numberBetween(10, 200),
            'foto'       => $item['foto'],
        ];
    }
}