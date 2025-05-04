@extends('layouts.app')
@section('title', 'Profile | ParkIt')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 4px rgba(0,0,0,0.06);max-width:400px;width:100%;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:1.5rem;">My Profile</h2>
        <div style="font-size:1.1rem;line-height:2;">
            <div><strong>Name:</strong> {{ session('user_name') }}</div>
            <div><strong>Phone:</strong> {{ session('user_phone') }}</div>
            <div><strong>Email:</strong> {{ session('user_email') }}</div>
            <div><strong>Type:</strong> {{ session('user_type') }}</div>
        </div>
        <div style="text-align:center;margin-top:1.5rem;display:flex;flex-direction:column;align-items:center;gap:1rem;">
            <a href="/profile/edit" style="background:#444;color:#fff;padding:0.5rem 1.5rem;border-radius:3px;font-weight:600;border:none;width:100%;max-width:300px;display:block;text-align:center;text-decoration:none;font-size:1.1rem;">Update Profile</a>
            <form method="POST" action="{{ route('profile.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');" style="width:100%;max-width:300px;">
                @csrf
                <button type="submit" style="background:#e3342f;color:#fff;padding:0.5rem 1.5rem;border-radius:3px;font-weight:600;border:none;width:100%;font-size:1.1rem;">Delete Account</button>
            </form>
        </div>
    </div>
</main>
@endsection
