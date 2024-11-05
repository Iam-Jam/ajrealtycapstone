<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$userTypes
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$userTypes)
    {
        if (!$request->user() || !in_array($request->user()->user_type, $userTypes)) {
            // You can customize this response based on your needs
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
            // Alternatively, you could use:
            // abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
