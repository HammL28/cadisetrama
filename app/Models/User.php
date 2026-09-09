<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<string>
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

        // Opsi Pengaturan Struk
        'receipt_footer_msg',
        'receipt_social',
        'show_qr_on_receipt',
        'paper_size',
        'auto_print_receipt',
        'open_cash_drawer',
        'show_cashier_name',
        'show_customer_name',
        'show_tax_discount_breakdown',
    ];

    /**
     * Atribut yang disembunyikan untuk serialisasi.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast Tipe Data Atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'           => 'datetime',
            'password'                    => 'hashed',
            
            // Decimal Casts
            'tax_rate'                    => 'float',
            'service_charge'              => 'float',

            // Boolean Casts
            'tax_inclusive'               => 'boolean',
            'enable_cash'                 => 'boolean',
            'enable_qris'                 => 'boolean',
            'enable_transfer'             => 'boolean',
            'email_notifications'         => 'boolean',
            'sales_notifications'         => 'boolean',
            'stock_notifications'         => 'boolean',
            'show_qr_on_receipt'          => 'boolean',
            'auto_print_receipt'          => 'boolean',
            'open_cash_drawer'            => 'boolean',
            'show_cashier_name'           => 'boolean',
            'show_customer_name'          => 'boolean',
            'show_tax_discount_breakdown' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}