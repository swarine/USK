<?php
// app/Http/Middleware/AuthPelanggan.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthPelanggan
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::get('role') !== 'pelanggan') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai pelanggan terlebih dahulu.');
        }
        return $next($request);
    }
}
