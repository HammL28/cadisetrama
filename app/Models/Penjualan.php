<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    // Mengunci nama tabel sesuai database Anda (tanpa akhiran 's')
    protected $table = 'penjualan';

    protected $fillable = [
        'user_id',
        'total_pembayaran',
        'metode_pembayaran',
        'status'
    ];

    // Relasi ke User (Kasir)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Item Penjualan
    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class, 'penjualan_id');
    }
}