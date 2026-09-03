<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
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

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => 2, // Default role: kasir
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    public function sendResetLinkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ], [
        'email.required' => 'Email wajib diisi.',
        'email.email'    => 'Format email tidak valid.',
        'email.exists'   => 'Email tidak ditemukan di sistem.',
    ]);

    // Buat token reset resmi Laravel
    $user = User::where('email', $request->email)->first();
    $token = Password::createToken($user);

    // Buat URL lengkap untuk reset password
    $resetUrl = route('password.reset', [
        'token' => $token,
        'email' => $request->email,
    ]);

    // Kirim pesan status dan tautan simulasi ke session
    return back()
        ->with('status', 'Permintaan reset password berhasil diproses!')
        ->with('demo_link', $resetUrl);
}

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.exists'       => 'Email tidak ditemukan di sistem.',
            'password.required'  => 'Kata sandi baru wajib diisi.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui! Silakan masuk.')
            : back()->withErrors(['email' => __($status)]);
    }

    public function logout(Request $request)
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
                Auth::login($user);
                return redirect()->route('dashboard')
                    ->with('success', 'Selamat Datang kembali, ' . $user->name);
            }
            
            // Cek apakah email sudah terdaftar
            $existingUser = User::where('email', $googleUser->email)->first();
            
            if ($existingUser) {
                $existingUser->google_id = $googleUser->id;
                $existingUser->save();
                Auth::login($existingUser);
                return redirect()->route('dashboard')
                    ->with('success', 'Akun Google berhasil terhubung! Selamat Datang, ' . $existingUser->name);
            }
            
            // User baru
            $newUser = User::create([
                'name'          => $googleUser->name,
                'email'         => $googleUser->email,
                'google_id'     => $googleUser->id,
                'google_avatar' => $googleUser->avatar,
                'password'      => bcrypt(rand(100000, 999999)),
                'role_id'       => 2,
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