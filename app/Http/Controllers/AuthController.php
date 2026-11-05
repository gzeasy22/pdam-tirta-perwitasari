<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ==========================================
        // 🛡️ PILAR 2: RATE LIMITING (ANTI BRUTE-FORCE)
        // ==========================================
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            Log::warning("Brute force terdeteksi dari IP: {$request->ip()} untuk email: {$request->email}");
            
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ])->onlyInput('email');
        }

        // ==========================================
        // PROSES AUTENTIKASI & LOGIC RBAC
        // ==========================================
        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);

            Auth::logoutOtherDevices($request->password); // Tendangan maut device lain
            $request->session()->regenerate();

            // 🚦 ARAHKAN 6 ROLE KE DASHBOARD MASING-MASING
            $role = Auth::user()->role;

            switch ($role) {
                case 'super_admin':
                case 'kepala_cabang':
                    return redirect()->intended('/dashboard'); 
                case 'petugas_pemasangan':
                    return redirect()->intended('admin/pelanggan'); 
                case 'kasir':
                    return redirect()->intended('admin/data-tagihan');
                case 'petugas_meter':
                    return redirect()->intended('admin/pencatatan-meter');
                case 'admin_berita': // ✅ Udah aman masuk radar!
                    return redirect()->intended('admin/berita');
                default:
                    return redirect()->intended('/dashboard');
            }
        }

        // Kalau gagal, catat dosanya di Rate Limiter (Hukuman 60 detik kalau 5x salah)
        RateLimiter::hit($throttleKey, 60); 

        return back()->withErrors([
            'email' => 'Email atau password salah nih bre.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}