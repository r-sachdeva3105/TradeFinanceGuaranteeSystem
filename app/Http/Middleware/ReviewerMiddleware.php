<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReviewerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the 'reviewer' user_type
        if (auth()->check() && auth()->user()->user_type === 'reviewer') {
            return $next($request);
        }

        // Redirect to applicant dashboard if not a reviewer
        return redirect()->route('dashboard.applicant');
    }
}
