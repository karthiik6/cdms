<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            return redirect('/admin/dashboard');
        }
        if ($role === 'donor') {
            return redirect('/donor/dashboard');
        }
        if ($role === 'volunteer') {
            return redirect('/volunteer/dashboard');
        }
        if ($role === 'customer') {
            return redirect('/customer/dashboard');
        }

        return redirect('/');
    }
}
