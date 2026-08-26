<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'google_id',
        'google_avatar',
        
        // Profil Toko
        'store_name',
        'store_phone',
        'store_address',

        // Pajak & Biaya Tambahan
        'tax_rate',
        'service_charge',
        'tax_inclusive',

        // Metode Pembayaran
        'enable_cash',
        'enable_qris',
        'enable_transfer',

        // Pengaturan Notifikasi
        'email_notifications',
        'sales_notifications',
        'stock_notifications',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'password'            => 'hashed',
            
            // Decimal Casts
            'tax_rate'            => 'float',
            'service_charge'      => 'float',

            // Boolean Casts
            'tax_inclusive'       => 'boolean',
            'enable_cash'         => 'boolean',
            'enable_qris'         => 'boolean',
            'enable_transfer'     => 'boolean',
            'email_notifications' => 'boolean',
            'sales_notifications' => 'boolean',
            'stock_notifications' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}