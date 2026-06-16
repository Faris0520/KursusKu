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
        if (!$request->user() || !$request->user()->isMentor()) {
            abort(403);
        }

        if (!$request->user()->isVerified()) {
            return redirect()->route('mentor.pending');
        }

        return $next($request);
    }
}
