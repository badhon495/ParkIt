@extends('layouts.app')
@section('title', 'Sign Up | ParkIt')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="display:flex;flex:1;max-width:1100px;width:100%;gap:2rem;">
        <div style="flex:1;display:flex;align-items:center;justify-content:center;">
            <h1 style="font-size:2.8rem;font-weight:700;color:#555;line-height:1.1;text-align:center;">Ensure Your Account Details Are Current</h1>
        </div>
        <div style="flex:1;max-width:400px;margin:auto;">
            <div style="background:#fff;padding:2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                <form method="POST" action="/signup" style="display:flex;flex-direction:column;gap:1rem;">
                    @csrf
                    <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:1rem;">Sign Up</h2>
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Name" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="Phone Number" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                    <select name="type" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                        <option value="">User Type</option>
                        <option value="user">User</option>
                        <option value="owner">Owner</option>
                    </select>
                    <button type="submit" style="background:#444;color:#fff;padding:0.5rem 0;border:none;border-radius:3px;font-size:1rem;font-weight:600;">Sign Up</button>
                    <div style="text-align:center;font-size:1rem;margin-top:0.5rem;">Already has account? <a href="/signin">Log in</a></div>
                    @if ($errors->any())
                        <div style="color:red;text-align:center;">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    @if (session('success'))
                        <div id="signup-success" style="color:green;text-align:center;margin-top:1.5rem;font-weight:600;">
                            {{ session('success') }}
                        </div>
                        <script>
                            setTimeout(function() {
                                window.location.href = '/signin';
                            }, 2000);
                        </script>
                    @endif
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
