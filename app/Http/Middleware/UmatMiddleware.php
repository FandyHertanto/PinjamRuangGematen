<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmatMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role_id == 2) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Unauthorized action.');
    }
}
