<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureGuestId
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guestId = $request->cookie('guest_id');

        // ❗ If no guest_id → redirect login
        if (!$guestId) {
            return redirect('/login');
        }

        return $next($request);
    }
}