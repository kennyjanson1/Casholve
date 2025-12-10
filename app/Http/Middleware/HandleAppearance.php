<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleAppearance
{
    public function handle(Request $request, Closure $next): Response
    {
        // Tetap ambil cookie, tapi tidak kirim lewat inertia() di sini
        $request->attributes->set(
            'appearance',
            $request->cookie('appearance', 'light')
        );

        return $next($request);
    }
}
