<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Memeriksa apakah pengguna sudah login dan memiliki peran 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Melanjutkan permintaan jika pengguna adalah admin
        }

        // Jika pengguna bukan admin, arahkan mereka ke halaman lain atau berikan respons yang sesuai
        return redirect('/')->with('error', 'Anda tidak memiliki akses.');
    }
}
