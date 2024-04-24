<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfExpired
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && $request->session()->has('last_activity')) {
            $lastActivity = $request->session()->get('last_activity');
            $sessionLifetime = config('session.lifetime') * 60; // Convert to seconds

            if (time() - $lastActivity > $sessionLifetime) {
                Auth::logout(); // Log out the user
                return redirect()->route('login'); // Redirect to the login page
            }
        }

        return $next($request);
    }
}