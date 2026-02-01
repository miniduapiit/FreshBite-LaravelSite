<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLoginForm()
    {
        // If already authenticated as admin, redirect to dashboard
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return redirect('/admin/dashboard');
        }
        
        return view('admin.login');
    }

    /**
     * Handle admin login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check if user is admin
            if ($user->hasRole('admin')) {
                $request->session()->regenerate();
                return redirect('/admin/dashboard');
            }
            
            // If not admin, logout and show error
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            throw ValidationException::withMessages([
                'email' => ['You do not have administrator access.'],
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}
