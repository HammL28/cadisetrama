<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CheckNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check user settings
        $user = User::find(6); // Change to your user ID
        if ($user) {
            echo "User: {$user->name}\n";
            echo "Email Notifications: " . ($user->email_notifications ? 'ON' : 'OFF') . "\n";
            echo "Sales Notifications: " . ($user->sales_notifications ? 'ON' : 'OFF') . "\n";
            echo "Stock Notifications: " . ($user->stock_notifications ? 'ON' : 'OFF') . "\n";
        }

        // Check notifications
        $notifications = DB::table('notifications')->get();
        echo "\nTotal Notifications: " . $notifications->count() . "\n";
        
        foreach ($notifications as $notif) {
            echo "ID: {$notif->id}, Type: {$notif->type}, Notifiable ID: {$notif->notifiable_id}\n";
        }
    }
}
