<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Kalo belum login, tendang ke halaman login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role;
        $allowedRoles = $roles;

        // ==========================================
        // 🚀 CHEAT CODE MULTI-CABANG DIMULAI
        // ==========================================
        // Kalau ruangan ini boleh dibuka sama 'super_admin', 
        // maka 'kepala_cabang' otomatis kita kasih tiket masuk juga!
        // (Aman, karena aksi edit/hapus udah digembok di Controller & View)
        if (in_array('super_admin', $allowedRoles) && !in_array('kepala_cabang', $allowedRoles)) {
            $allowedRoles[] = 'kepala_cabang';
        }
        // ==========================================

        // 2. Kalo rolenya tetep gak ada di daftar izin, tendang balik
        if (!in_array($userRole, $allowedRoles)) {
            // Arahin ke halaman yang paling netral dan kasih pesan error
            return redirect()->route('admin.pelanggan')->with('error', '🛑 Akses Ditolak! Jabatan lu gak punya izin buka halaman ini bre!');
        }

        // 3. Kalo aman, silakan masuk bos!
        return $next($request);
    }
}