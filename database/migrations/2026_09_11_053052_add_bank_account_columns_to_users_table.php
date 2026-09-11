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
            $table->string('bca_account_number')->nullable();
            $table->string('bca_account_holder')->nullable();
            $table->string('mandiri_account_number')->nullable();
            $table->string('mandiri_account_holder')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bca_account_number',
                'bca_account_holder',
                'mandiri_account_number',
                'mandiri_account_holder',
            ]);
        });
    }
};