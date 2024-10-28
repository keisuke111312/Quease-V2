<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $role = Auth::user()->role;
    
            if ($role == '2') { 
                return redirect('/admin/dashboard'); // Redirect superadmin to dashboard
            } elseif ($role == '1') {
                return redirect('/faculty/home'); // Redirect admin to dashboard
            } else {
                return redirect('/student/home'); // Redirect regular user to home
            }
        }
    
        return $next($request);
    }
}
