<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.a-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == '2') {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Invalid username or password..']);
            }
        }

        return redirect()->back()->withErrors(['email' => 'Invalid login credentials.']);
    }
}
