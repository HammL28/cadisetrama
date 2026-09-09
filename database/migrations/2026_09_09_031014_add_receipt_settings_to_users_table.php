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
            $table->string('receipt_footer_msg')->default('Terima Kasih!')->nullable()->after('store_address');
            $table->string('receipt_social')->nullable()->after('receipt_footer_msg');
            $table->boolean('show_qr_on_receipt')->default(true)->after('receipt_social');
            $table->string('paper_size', 10)->default('58mm')->after('show_qr_on_receipt');
            $table->boolean('auto_print_receipt')->default(true)->after('paper_size');
            $table->boolean('open_cash_drawer')->default(true)->after('auto_print_receipt');
            $table->boolean('show_cashier_name')->default(true)->after('open_cash_drawer');
            $table->boolean('show_customer_name')->default(true)->after('show_cashier_name');
            $table->boolean('show_tax_discount_breakdown')->default(true)->after('show_customer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'receipt_footer_msg',
                'receipt_social',
                'show_qr_on_receipt',
                'paper_size',
                'auto_print_receipt',
                'open_cash_drawer',
                'show_cashier_name',
                'show_customer_name',
                'show_tax_discount_breakdown',
            ]);
        });
    }
};