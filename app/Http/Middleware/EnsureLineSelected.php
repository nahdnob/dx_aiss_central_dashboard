<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLineSelected
{
    /**
     * Handle an incoming request.
     * Jika belum memilih line, redirect ke halaman line-selector.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('selected_line_id')) {
            return redirect()->route('dashboards.index')
                ->with('info', 'Silakan pilih Line terlebih dahulu melalui modal pada dashboard.');
        }

        return $next($request);
    }
}
