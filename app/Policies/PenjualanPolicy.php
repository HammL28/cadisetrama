<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class PenjualanPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['admin', 'kasir'], true);
    }

    public function view(User $user, Penjualan $penjualan): bool
    {
        // Admin bisa lihat semua transaksi
        if ($user->role->name === 'admin') {
            return true;
        }
        
        // Kasir hanya bisa lihat transaksi sendiri
        return $user->role->name === 'kasir' && $penjualan->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role->name, ['admin', 'kasir'], true);
    }

    public function update(User $user, Penjualan $penjualan): bool
    {
        // Admin bisa update semua transaksi OPEN
        if ($user->role->name === 'admin' && $penjualan->status === 'OPEN') {
            return true;
        }
        
        // Kasir hanya bisa update transaksi sendiri yang masih OPEN
        return $user->role->name === 'kasir' 
            && $penjualan->user_id === $user->id 
            && $penjualan->status === 'OPEN';
    }

    public function delete(User $user, Penjualan $penjualan): bool
    {
        // Admin bisa delete semua transaksi OPEN
        if ($user->role->name === 'admin' && $penjualan->status === 'OPEN') {
            return true;
        }
        
        // Kasir hanya bisa delete transaksi sendiri yang masih OPEN
        return $user->role->name === 'kasir' 
            && $penjualan->user_id === $user->id 
            && $penjualan->status === 'OPEN';
    }
}