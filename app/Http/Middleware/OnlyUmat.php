<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OnlyUmat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Memeriksa apakah pengguna sudah login dan memiliki peran 'umat'
        if (Auth::check() && Auth::user()->role === 'umat') {
            return $next($request); // Melanjutkan permintaan jika pengguna adalah umat
        }

        // Jika pengguna bukan umat, arahkan mereka ke halaman lain atau berikan respons yang sesuai
        return redirect('/')->with('error', 'Anda tidak memiliki akses.');
    }
}
