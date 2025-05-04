@extends('layouts.app')
@section('title', 'Sign In | ParkIt')
@section('content')
<div style="min-height:calc(100vh - 120px);display:flex;align-items:center;justify-content:center;">
    <div style="display:flex;flex:1;max-width:1100px;width:100%;gap:2rem;">
        <div style="flex:1;display:flex;align-items:center;justify-content:center;">
            <h1 style="font-size:2.8rem;font-weight:700;color:#555;line-height:1.1;text-align:center;">Welcome Back.<br>Find Your Garage Here</h1>
        </div>
        <div style="flex:1;max-width:400px;margin:auto;">
            <div style="background:white;padding:2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:1.5rem;">Login</h2>
                <form method="POST" action="/signin" style="display:flex;flex-direction:column;gap:1.2rem;">
                    @csrf
                    <input type="text" name="login" placeholder="Email or Phone Number" required style="padding:0.7rem 1rem;border:1px solid #aaa;border-radius:3px;font-size:1rem;">
                    <input type="password" name="password" placeholder="Password" required style="padding:0.7rem 1rem;border:1px solid #aaa;border-radius:3px;font-size:1rem;">
                    <button type="submit" style="background:#444;color:#fff;padding:0.6rem 0;border:none;border-radius:5px;font-size:1.1rem;font-weight:600;">Log In</button>
                    @if ($errors->has('login'))
                        <div style="color:red;text-align:center;">{{ $errors->first('login') }}</div>
                    @endif
                </form>
                <div style="text-align:center;margin-top:1rem;">
                    <a href="/forgot-password" style="color:#444;text-decoration:underline;font-size:0.98rem;">Forgot Password</a>
                </div>
                <div style="text-align:center;margin-top:0.5rem;font-size:1rem;">
                    New here? <a href="/signup" style="color:#444;text-decoration:underline;">Open an account</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
