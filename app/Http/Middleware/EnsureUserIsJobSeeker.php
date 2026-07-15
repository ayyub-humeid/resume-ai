<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsJobSeeker
{
    // Check if user has job_seeker role, if not redirect to their dashboard
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isJobSeeker()) {
            return $next($request);
        }

        // Redirect to their appropriate dashboard
        return redirect(auth()->user()->getDashboardUrl());
    }
}
