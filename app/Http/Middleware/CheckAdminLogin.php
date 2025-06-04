<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckAdminLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_id') || session('role_id') != 1) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai admin.');
        }

        return $next($request);
    }
}
