<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class FixNotificationSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fix NULL values for existing users
        User::whereNull('email_notifications')->update([
            'email_notifications' => true,
            'sales_notifications' => true,
            'stock_notifications' => false,
        ]);
    }
}
