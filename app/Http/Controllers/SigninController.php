<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SigninController extends Controller
{
    public function showForm()
    {
        return view('signin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string', // can be phone or email
            'password' => 'required|string',
        ]);

        // Hardcoded admin login
        if (($request->login === 'admin@gmail.com' || $request->login === 'admin') && $request->password === 'admin123') {
            Session::put('user_id', 0);
            Session::put('user_name', 'Admin');
            Session::put('user_type', 'admin');
            Session::put('user_phone', 'N/A');
            Session::put('user_email', 'admin@gmail.com');
            return redirect('/admin/bookings')->with('success', 'Logged in as admin!');
        }

        $user = DB::table('users')
            ->where('phone', $request->login)
            ->orWhere('email', $request->login)
            ->first();
        if ($user) {
            if (empty($user->password)) {
                return back()->withErrors(['login' => 'This account was created with Google. Please log in using Google Sign-In.'])->withInput();
            }
            if (Hash::check($request->password, $user->password)) {
                // Store user info in session
                Session::put('user_id', $user->id);
                Session::put('user_name', $user->name);
                Session::put('user_type', $user->type);
                Session::put('user_phone', $user->phone);
                Session::put('user_email', $user->email);
                // If admin user in DB, also set admin type
                if ($user->email === 'admin@gmail.com') {
                    Session::put('user_type', 'admin');
                }
                return redirect('/')->with('success', 'Logged in successfully!');
            }
        }
        return back()->withErrors(['login' => 'Invalid email/phone or password'])->withInput();
    }

    public function logout()
    {
        Session::flush();
        return redirect('/signin')->with('success', 'Logged out successfully!');
    }
}
