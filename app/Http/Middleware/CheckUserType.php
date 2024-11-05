<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->type, ['admin', 'seller', 'agent1', 'agent2'])) {
            return redirect()->route('forms.index')
                ->with('info', 'Please visit our Forms page and select Contact Inquiry to submit your inquiry.');
        }

        return $next($request);
    }
}
