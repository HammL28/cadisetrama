<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sidebar_brand_text', 50)->nullable()->after('sidebar_logo_shape');
            $table->string('sidebar_color_from', 20)->nullable()->after('sidebar_brand_text');
            $table->string('sidebar_color_to', 20)->nullable()->after('sidebar_color_from');
            $table->string('sidebar_bg_photo')->nullable()->after('sidebar_color_to');
            $table->unsignedTinyInteger('sidebar_bg_opacity')->default(25)->after('sidebar_bg_photo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'sidebar_brand_text',
                'sidebar_color_from',
                'sidebar_color_to',
                'sidebar_bg_photo',
                'sidebar_bg_opacity',
            ]);
        });
    }
};
