<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/signin')->with('error', 'Google authentication failed.');
        }

        $user = DB::table('users')->where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // User does not exist, show error
            return redirect('/signup')->with('error', 'No account found for this Google email. Please sign up first.');
        }

        // Log in user (set session)
        session(['user_id' => $user->id]);
        session(['user_name' => $user->name]);
        session(['user_type' => $user->type ?? 'user']);
        session(['user_phone' => $user->phone ?? '']);
        session(['user_email' => $user->email]);

        return redirect('/')->with('success', 'Logged in with Google!');
    }

    public function handleGoogleSignup()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/signup')->with('error', 'Google authentication failed.');
        }

        $user = DB::table('users')->where('email', $googleUser->getEmail())->first();
        if ($user) {
            return redirect('/signin')->with('error', 'User already exists. Please log in with Google.');
        }
        // Create user with Google info, no password/phone
        $userId = DB::table('users')->insertGetId([
            'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
            'email' => $googleUser->getEmail(),
            'password' => '',
            'type' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Log in user
        session(['user_id' => $userId]);
        session(['user_name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User']);
        session(['user_type' => 'user']);
        session(['user_phone' => '']);
        session(['user_email' => $googleUser->getEmail()]);
        return redirect('/')->with('success', 'Account created and logged in with Google!');
    }
}
