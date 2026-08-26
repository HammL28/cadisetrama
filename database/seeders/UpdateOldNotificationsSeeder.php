<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateOldNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update old notifications to include user info
        $notifications = DB::table('notifications')->get();
        
        foreach ($notifications as $notification) {
            $data = json_decode($notification->data, true);
            
            // If old format (without user_name), update it
            if (!isset($data['user_name']) && isset($data['sale_id'])) {
                // Get sale info
                $sale = DB::table('penjualan')->where('id', $data['sale_id'])->first();
                if ($sale) {
                    $user = DB::table('users')->where('id', $sale->user_id)->first();
                    if ($user) {
                        $role = DB::table('roles')->where('id', $user->role_id)->first();
                        $roleName = ucfirst($role->name ?? $role->NAME ?? 'User');
                        
                        $data['user_name'] = $user->name;
                        $data['user_role'] = $roleName;
                        $data['message'] = 'Penjualan baru #' . $data['sale_id'] . ' oleh ' . $user->name . ' (' . $roleName . ') dengan total Rp ' . number_format($data['total'] ?? 0, 0, ',', '.');
                        
                        DB::table('notifications')
                            ->where('id', $notification->id)
                            ->update(['data' => json_encode($data)]);
                    }
                }
            }
        }
        
        echo "Old notifications updated with user info.\n";
    }
}
