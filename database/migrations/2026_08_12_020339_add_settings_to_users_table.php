<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Profil Toko
            $table->string('store_name')->nullable()->after('email');
            $table->string('store_phone')->nullable()->after('store_name');
            $table->text('store_address')->nullable()->after('store_phone');

            // Pajak & Biaya Tambahan
            $table->decimal('tax_rate', 5, 2)->default(11.00)->after('store_address');
            $table->decimal('service_charge', 5, 2)->default(0.00)->after('tax_rate');
            $table->boolean('tax_inclusive')->default(false)->after('service_charge');

            // Metode Pembayaran
            $table->boolean('enable_cash')->default(true)->after('tax_inclusive');
            $table->boolean('enable_qris')->default(true)->after('enable_cash');
            $table->boolean('enable_transfer')->default(false)->after('enable_qris');

            // Pengaturan Notifikasi
            $table->boolean('email_notifications')->default(true)->after('enable_transfer');
            $table->boolean('sales_notifications')->default(true)->after('email_notifications');
            $table->boolean('stock_notifications')->default(false)->after('sales_notifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'store_name',
                'store_phone',
                'store_address',
                'tax_rate',
                'service_charge',
                'tax_inclusive',
                'enable_cash',
                'enable_qris',
                'enable_transfer',
                'email_notifications',
                'sales_notifications',
                'stock_notifications',
            ]);
        });
    }
};