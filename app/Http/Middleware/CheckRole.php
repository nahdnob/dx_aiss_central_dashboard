<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response {
        
        $user = $request->user();

        // Cek apakah user memiliki role yang diizinkan
        if (!$user || !in_array($user->role, $roles)) {

            // Jika tidak memiliki role yang diizinkan, redirect ke halaman 403
            abort(403, 'Akses ditolak. anda tidak memiliki akses ke halaman ini.');
        }

        // Lanjutkan ke request berikutnya
        return $next($request);
    }
}
