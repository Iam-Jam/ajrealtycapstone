<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureBuyer
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || (Auth::user()->user_type !== 'buyer' && Auth::user()->user_type !== 'admin')) {
            abort(403, 'Only buyers and admins can access this page.');
        }

        return $next($request);
    }
}
