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

        $user = DB::table('users')
            ->where('phone', $request->login)
            ->orWhere('email', $request->login)
            ->first();
        if ($user && Hash::check($request->password, $user->password)) {
            // Store user info in session
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            Session::put('user_type', $user->type);
            Session::put('user_phone', $user->phone);
            Session::put('user_email', $user->email);
            return redirect('/')->with('success', 'Logged in successfully!');
        }
        return back()->withErrors(['login' => 'Invalid email/phone or password'])->withInput();
    }

    public function logout()
    {
        Session::flush();
        return redirect('/signin')->with('success', 'Logged out successfully!');
    }
}
