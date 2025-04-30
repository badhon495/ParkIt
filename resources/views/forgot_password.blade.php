@extends('layouts.app')
@section('title', 'Forgot Password | ParkIt')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 4px rgba(0,0,0,0.06);max-width:400px;width:100%;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:1.5rem;">Forgot Password</h2>
        <form method="POST" action="/forgot-password" style="display:flex;flex-direction:column;gap:1rem;">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            <button type="submit" style="background:#444;color:#fff;padding:0.5rem 0;border:none;border-radius:3px;font-size:1rem;font-weight:600;">Send New Password</button>
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
