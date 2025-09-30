<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login dan memiliki role 'admin'
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        // Jika tidak, alihkan ke halaman utama atau berikan respons 403 (Forbidden)
        return redirect('/')->with('error', 'Akses ditolak. Anda bukan admin.');
    }
}
