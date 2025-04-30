<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required|in:user,owner,admin',
        ]);

        if ($validator->fails()) {
            return redirect('/signup')
                ->withErrors($validator)
                ->withInput();
        }

        DB::table('users')->insert([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'type' => $request->input('type'),
        ]);

        // Redirect back to signup with success message
        return redirect('/signup')->with('success', 'Signup completed! Redirecting to login...');
    }
}
