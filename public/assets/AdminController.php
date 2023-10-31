<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function Index()
    {
        return view('admin.admin_login');
    }

    public function Dashboard()
    {
        return view('admin.layout.app');
    }

    public function Login(request $request)
    {
        $check = $request->all();

        if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
            return redirect()->route('admin.dashboard')->with('error', 'admin Login Success');
        } else {
            return back()->with('error', 'Invalid emil or passowed');
        }
    }

    public function Admin_logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login_form')->with('error', 'admin Log out Success');
    }
}
