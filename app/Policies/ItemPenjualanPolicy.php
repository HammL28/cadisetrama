<?php

namespace App\Policies;

use App\Models\ItemPenjualan;
use App\Models\User;

class ItemPenjualanPolicy
{
    /**
     * Izinkan semua user terautentikasi untuk mengelola item penjualan.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ItemPenjualan $itemPenjualan): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ItemPenjualan $itemPenjualan): bool
    {
        return true;
    }

    public function delete(User $user, ItemPenjualan $itemPenjualan): bool
    {
        return true;
    }
}