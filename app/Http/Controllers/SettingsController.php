<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    /**
     * Update the user settings.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validatedData = $request->validate([
            'store_name'      => 'nullable|string|max:255',
            'store_phone'     => 'nullable|string|max:20',
            'store_address'   => 'nullable|string',
            'tax_rate'        => 'nullable|numeric|min:0|max:100',
            'service_charge'  => 'nullable|numeric|min:0|max:100',
        ]);

        // Debug log sebelum update
        Log::info('Updating settings for User ID: ' . $user->id);

        // Update data profil toko, pajak, metode pembayaran, dan notifikasi
        $user->update([
            // Profil Toko
            'store_name'          => $request->store_name,
            'store_phone'         => $request->store_phone,
            'store_address'       => $request->store_address,

            // Pajak & Biaya
            'tax_rate'            => $request->tax_rate ?? 0,
            'service_charge'      => $request->service_charge ?? 0,
            'tax_inclusive'       => $request->has('tax_inclusive'),

            // Metode Pembayaran
            'enable_cash'         => $request->has('enable_cash'),
            'enable_qris'         => $request->has('enable_qris'),
            'enable_transfer'     => $request->has('enable_transfer'),

            // Notifikasi
            'email_notifications' => $request->has('email_notifications'),
            'sales_notifications' => $request->has('sales_notifications'),
            'stock_notifications' => $request->has('stock_notifications'),
        ]);

        // Debug log setelah update
        Log::info('Settings updated successfully for User ID: ' . $user->id);

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    /**
     * Display user notifications.
     */
    public function notifications()
    {
        $user = Auth::user();
        
        // Ambil semua notifikasi milik user (termasuk yang sudah dibaca)
        $notifications = $user->notifications()->latest()->paginate(10);
        
        // Debug info
        Log::info('User ID: ' . $user->id);
        Log::info('Notifications count: ' . $notifications->count());
        Log::info('Unread count: ' . $user->unreadNotifications->count());
        
        return view('settings.notifications', compact('user', 'notifications'));
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        
        return back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        
        return back()->with('success', 'Semua notifikasi ditandai sebagai sudah dibaca.');
    }

    /**
     * Get unread notification count for polling.
     */
    public function unreadCount()
    {
        $user = Auth::user();
        $count = $user->unreadNotifications->count();
        $latestNotification = $user->unreadNotifications()->latest()->first();
        
        return response()->json([
            'count' => $count,
            'notification' => $latestNotification
        ]);
    }
}