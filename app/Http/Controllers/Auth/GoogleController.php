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
}
