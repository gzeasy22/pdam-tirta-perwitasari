<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user udah login DAN rolenya adalah 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request); // Boleh masuk
        }

        // Kalo bukan admin (misal pelanggan atau orang iseng), tendang ke halaman depan
        return redirect('/')->with('error', 'Maaf, halaman ini khusus Administrator!');
    }
}
