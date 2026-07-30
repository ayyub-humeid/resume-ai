<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsJobSeeker
{
    // Check if user has job_seeker or admin role, if not redirect to their dashboard
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isJobSeeker() || auth()->user()->isAdmin()) {
            return $next($request);
        }

        return redirect(auth()->user()->getDashboardUrl());
    }
}
