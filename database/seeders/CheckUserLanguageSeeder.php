<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CheckUserLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(7); // Change to your user ID
        if ($user) {
            echo "User ID: {$user->id}\n";
            echo "Name: {$user->name}\n";
            echo "Language: {$user->language}\n";
            echo "Email Notifications: " . ($user->email_notifications ? 'ON' : 'OFF') . "\n";
        } else {
            echo "User not found\n";
        }
    }
}
