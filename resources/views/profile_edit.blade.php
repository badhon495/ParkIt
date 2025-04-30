@extends('layouts.app')
@section('title', 'Update Profile | ParkIt')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 4px rgba(0,0,0,0.06);max-width:400px;width:100%;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:1.5rem;">Update Profile</h2>
        <form method="POST" action="/profile/edit" style="display:flex;flex-direction:column;gap:1rem;">
            @csrf
            <input type="text" name="name" value="{{ old('name', session('user_name')) }}" placeholder="Name" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            <input type="text" name="phone" value="{{ old('phone', session('user_phone')) }}" placeholder="Phone Number" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            <input type="email" name="email" value="{{ old('email', session('user_email')) }}" placeholder="Email" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            <input type="password" name="current_password" placeholder="Current Password (leave blank if not changing)" style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            <input type="password" name="new_password" placeholder="New Password" style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            <input type="password" name="new_password_confirmation" placeholder="Confirm New Password" style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            <button type="submit" style="background:#444;color:#fff;padding:0.5rem 0;border:none;border-radius:3px;font-size:1rem;font-weight:600;">Update</button>
            @if ($errors->any())
                <div style="color:red;text-align:center;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @if (session('success'))
                <div style="color:green;text-align:center;margin-top:1rem;font-weight:600;">
                    {{ session('success') }}
                </div>
            @endif
        </form>
    </div>
</main>
@endsection
