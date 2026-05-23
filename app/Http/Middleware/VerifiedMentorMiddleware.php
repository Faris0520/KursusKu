<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedMentorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isMentor() || !$request->user()->isVerified()) {
            abort(403, 'Akun mentor belum diverifikasi, silakan hubungi admin untuk informasi lebih lanjut.');
        }

        return $next($request);
    }
}
