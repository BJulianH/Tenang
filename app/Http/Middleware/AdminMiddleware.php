<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Sesuaikan nama field admin kamu
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            redirect()->route('dashboard');
        }

        return $next($request);
    }
}
