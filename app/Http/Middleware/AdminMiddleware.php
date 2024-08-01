<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && in_array($user->role_id, [1, 3])) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Unauthorized action.');
    }
}
