<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function auth(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {

            $request->session()->regenerate();

            return redirect()->route('dashboard')
                ->with('success', 'Selamat Datang, ' . Auth::user()->name);
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid'
        ]);
    }

    public function logout(Request $request) // <-- diperbaiki di sini
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah keluar aplikasi!');
    }

    // Google Login Methods
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cek apakah user sudah ada berdasarkan google_id
            $user = User::where('google_id', $googleUser->id)->first();
            
            if ($user) {
                // User sudah ada, login langsung
                Auth::login($user);
                return redirect()->route('dashboard')
                    ->with('success', 'Selamat Datang kembali, ' . $user->name);
            }
            
            // Cek apakah email sudah terdaftar
            $existingUser = User::where('email', $googleUser->email)->first();
            
            if ($existingUser) {
                // Email sudah ada tapi belum terhubung dengan Google
                // Hubungkan akun Google dengan user yang sudah ada
                $existingUser->google_id = $googleUser->id;
                $existingUser->save();
                Auth::login($existingUser);
                return redirect()->route('dashboard')
                    ->with('success', 'Akun Google berhasil terhubung! Selamat Datang, ' . $existingUser->name);
            }
            
            // User baru, buat user baru
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'google_avatar' => $googleUser->avatar,
                'password' => bcrypt(rand(100000, 999999)), // Random password
                'role_id' => 2, // Default role: kasir (sesuaikan dengan database)
            ]);
            
            Auth::login($newUser);
            return redirect()->route('dashboard')
                ->with('success', 'Akun berhasil dibuat! Selamat Datang, ' . $newUser->name);
            
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Login Google gagal: ' . $e->getMessage());
        }
    }
}