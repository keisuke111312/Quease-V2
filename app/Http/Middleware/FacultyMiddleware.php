<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacultyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->role ==1 || Auth::user()->role ==3 ){
                return $next($request);
            }elseif(Auth::user()->role == 2){
                return redirect('/admin/dashboard');
            }
             else{
                return redirect('/student/home')->with('message', 'Access Denied');
            }
            
        } else{
            return redirect('/')->with('message', 'Access Denied');
        }
        // return $next($request);
    }
}
