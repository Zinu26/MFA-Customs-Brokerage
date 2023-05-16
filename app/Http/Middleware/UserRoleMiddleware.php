<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $userType)
    {
        if (Auth::check() && Auth::user()->type == $userType) {
            return $next($request);
        }

        return redirect()->back()
            ->withErrors(['login' => 'You do not have permission to access the page. Please logout first.'])
            ->withInput()
            ->with('warning', 'You do not have permission to access the page. Please logout first.');
    }
}
