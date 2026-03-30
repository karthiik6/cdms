<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show registration form (role comes from /register?role=donor|volunteer|customer)
    public function showRegister(Request $request)
    {
        $role = $request->query('role'); // donor / volunteer / customer

        return view('auth.register', compact('role'));
    }

    // Show login form (role comes from /login?role=admin|donor|volunteer|customer)
    public function showLogin(Request $request)
    {
        $role = $request->query('role'); // admin / donor / volunteer / customer

        return view('auth.login', compact('role'));
    }

    // Register user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+()\\-\\s]{7,20}$/'],
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:donor,volunteer,customer', // admin not allowed from register
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // redirect to correct login portal
        return redirect('/login?role='.$request->role)->with('success', 'Registration successful. Please login.');
    }

    // Login user (role restricted)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,donor,volunteer,customer',
        ]);

        // attempt login
        if (! Auth::attempt($request->only('email', 'password'))) {
            return back()->with('error', 'Invalid credentials');
        }

        $request->session()->regenerate();

        // enforce role match (portal restriction)
        $expectedRole = $request->role;        // role from login page hidden input
        $actualRole = auth()->user()->role;  // role from DB

        if ($actualRole !== $expectedRole) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->with('error', 'You cannot login from this portal. Please use the correct login button.');
        }

        // redirect based on role
        if ($actualRole === 'admin') {
            return redirect('/admin/dashboard');
        }
        if ($actualRole === 'donor') {
            return redirect('/donor/dashboard');
        }
        if ($actualRole === 'volunteer') {
            return redirect('/volunteer/dashboard');
        }
        if ($actualRole === 'customer') {
            return redirect('/customer/dashboard');
        }

        return redirect('/dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // go back to landing (or admin login if you prefer)
        return redirect('/');
    }
}
