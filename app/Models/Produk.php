<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'user_id',
        'foto',
        'jenis',
        'nama',
        'harga_beli',
        'harga_jual',
        'stok',
    ];

    protected $casts = [
        'harga_beli' => 'integer',
        'harga_jual' => 'integer',
        'stok'       => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}