<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAkses
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Periksa apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Periksa apakah role user termasuk yang diizinkan
        foreach ($roles as $role) {
            if ($user->jenis == $role) {
                return $next($request);
            }
        }

        // Jika role tidak sesuai
        Auth::logout();
        return redirect()->route('login')
            ->withErrors(['akses' => 'Anda tidak memiliki akses ke halaman ini']);
    }
}