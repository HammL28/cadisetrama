<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Menampilkan halaman pengaturan beserta data penjualan.
     */
    public function index()
    {
        $user = Auth::user();

        // Mengambil data penjualan agar tidak terjadi error Undefined variable $penjualan
        $penjualan = Penjualan::where('user_id', $user->id)->latest()->get();

        return view('settings.index', compact('user', 'penjualan'));
    }

    /**
     * Memperbarui pengaturan user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input dari form
        $request->validate([
            'store_name'           => 'nullable|string|max:255',
            'receipt_header_title' => 'nullable|string|max:255',
            'store_phone'          => 'nullable|string|max:20',
            'receipt_phone'        => 'nullable|string|max:20',
            'store_address'        => 'nullable|string',
            'receipt_address'      => 'nullable|string',
            'tax_rate'             => 'nullable|numeric|min:0|max:100',
            'service_charge'       => 'nullable|numeric|min:0|max:100',

            // Rekening Bank
            'bca_account_number'     => 'nullable|string|max:50',
            'bca_account_holder'     => 'nullable|string|max:255',
            'mandiri_account_number' => 'nullable|string|max:50',
            'mandiri_account_holder' => 'nullable|string|max:255',

            // Kustomisasi Sidebar
            'sidebar_brand_text' => 'nullable|string|max:50',
            'sidebar_color_from' => 'nullable|string|max:20',
            'sidebar_color_to'   => 'nullable|string|max:20',
            'sidebar_bg_photo'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
            'sidebar_bg_opacity' => 'nullable|integer|min:0|max:80',
            'sidebar_logo_shape' => 'nullable|in:circle,square',
        ]);

        // Tangkap input (prioritaskan input form baru, lalu form lama, lalu data eksisting)
        $storeName    = $request->receipt_header_title ?? $request->store_name ?? $user->store_name;
        $storePhone   = $request->receipt_phone ?? $request->store_phone ?? $user->store_phone;
        $storeAddress = $request->receipt_address ?? $request->store_address ?? $user->store_address;

        // Debug log sebelum update
        Log::info('Updating settings for User ID: ' . $user->id);

        // Tangani upload foto latar sidebar (opsional, hanya jika user upload file baru)
        $sidebarBgPhoto = $user->sidebar_bg_photo; // default: pertahankan foto lama
        if ($request->hasFile('sidebar_bg_photo')) {
            // Hapus foto lama supaya storage tidak menumpuk
            if ($user->sidebar_bg_photo && Storage::disk('public')->exists($user->sidebar_bg_photo)) {
                Storage::disk('public')->delete($user->sidebar_bg_photo);
            }

            $sidebarBgPhoto = $request->file('sidebar_bg_photo')->store('sidebar', 'public');
        }

        // Update data profil toko, pajak, metode pembayaran, dan opsi struk
        $user->update([
            // Profil Toko Utama
            'store_name'                   => $storeName,
            'store_phone'                  => $storePhone,
            'store_address'                => $storeAddress,

            // Pajak & Biaya
            'tax_rate'                     => $request->tax_rate ?? $user->tax_rate ?? 0,
            'service_charge'               => $request->service_charge ?? $user->service_charge ?? 0,
            'tax_inclusive'                => $request->has('tax_inclusive'),

            // Metode Pembayaran
            'enable_cash'                  => $request->has('enable_cash'),
            'enable_qris'                  => $request->has('enable_qris'),
            'enable_transfer'              => $request->has('enable_transfer'),

            // Rekening Bank
            'bca_account_number'     => $request->bca_account_number ?? $user->bca_account_number,
            'bca_account_holder'     => $request->bca_account_holder ?? $user->bca_account_holder,
            'mandiri_account_number' => $request->mandiri_account_number ?? $user->mandiri_account_number,
            'mandiri_account_holder' => $request->mandiri_account_holder ?? $user->mandiri_account_holder,

            // Notifikasi
            'email_notifications'          => $request->has('email_notifications'),
            'sales_notifications'          => $request->has('sales_notifications'),
            'stock_notifications'          => $request->has('stock_notifications'),

            // Opsi Tambahan Struk
            'receipt_footer_msg'           => $request->receipt_footer_msg ?? 'Terima Kasih!',
            'receipt_social'               => $request->receipt_social,
            'show_qr_on_receipt'           => $request->has('show_qr_on_receipt'),
            'paper_size'                   => $request->paper_size ?? '58mm',
            'auto_print_receipt'           => $request->has('auto_print_receipt'),
            'open_cash_drawer'             => $request->has('open_cash_drawer'),
            'show_cashier_name'            => $request->has('show_cashier_name'),
            'show_customer_name'           => $request->has('show_customer_name'),
            'show_tax_discount_breakdown'  => $request->has('show_tax_discount_breakdown'),

            // Kustomisasi Sidebar
            'sidebar_brand_text' => $request->sidebar_brand_text ?? $user->sidebar_brand_text ?? 'POS ILHAM',
            'sidebar_color_from' => $request->sidebar_color_from ?? $user->sidebar_color_from ?? '#4f46e5',
            'sidebar_color_to'   => $request->sidebar_color_to ?? $user->sidebar_color_to ?? '#e879f9',
            'sidebar_bg_photo'   => $sidebarBgPhoto,
            'sidebar_bg_opacity' => $request->sidebar_bg_opacity ?? $user->sidebar_bg_opacity ?? 25,
            'sidebar_logo_shape' => $request->sidebar_logo_shape ?? $user->sidebar_logo_shape ?? 'circle',
        ]);

        // Debug log setelah update
        Log::info('Settings updated successfully for User ID: ' . $user->id);

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    /**
     * Menampilkan notifikasi user.
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
     * Tandai notifikasi sebagai sudah dibaca.
     */
    public function markAsRead($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi ditandai sebagai sudah dibaca.');
    }

    /**
     * Ambil jumlah notifikasi belum dibaca untuk polling JS.
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