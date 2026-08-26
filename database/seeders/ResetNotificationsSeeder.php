<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset all notifications to unread
        DB::table('notifications')->where('read_at', '!=', null)->update(['read_at' => null]);
        
        echo "All notifications have been reset to unread status.\n";
    }
}
