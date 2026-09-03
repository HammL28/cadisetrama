<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Account Admin (role_id = 1)
        User::create([
            'name'     => 'Muhammad Ilham',
            'email'    => 'daniel@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id'  => 1,
        ]);

        // Account Kasir (role_id = 2)
        User::create([
            'name'     => 'Kasir Toko',
            'email'    => 'kasir@gmail.com',
            'password' => Hash::make('password123'),
            'role_id'  => 2,
        ]);
    }
}