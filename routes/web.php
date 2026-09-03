<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;

// --- REDIRECT HALAMAN UTAMA ---
Route::get('/', function () {
    return redirect()->route('login');
});

// --- GUEST ROUTES ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
    
    // Route Registrasi Akun
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    
    // Route Lupa & Reset Sandi
    Route::get('/forgot-password', function () {
        return redirect()->route('login');
    })->name('password.request');
    
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    
    // Google OAuth Routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// --- AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {
    
    // Dashboard & Logout
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', function() {
        return redirect()->route('login')->with('error', 'Silakan gunakan tombol logout untuk keluar dengan aman.');
    })->name('logout.get');

    // --- FITUR PROFIL & GANTI PASSWORD (Bisa diakses Semua Role) ---
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.index');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');

    // --- FITUR PENGATURAN (Bisa diakses Semua Role) ---
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/update', [SettingsController::class, 'update'])->name('settings.update');

    // --- FITUR NOTIFIKASI (Bisa diakses Semua Role) ---
    Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [SettingsController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [SettingsController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/api/unread-count', [SettingsController::class, 'unreadCount'])->name('api.unread-count');

    // --- KHUSUS ADMIN ---
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Kelola Users
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');  
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // --- ADMIN & KASIR ---
    Route::middleware('role:admin,kasir')->group(function () {
        Route::resource('produk', ProdukController::class);
        Route::resource('penjualan', PenjualanController::class);
        Route::resource('itempenjualan', ItemPenjualanController::class);
        Route::resource('jenis', JenisController::class);
    });

});