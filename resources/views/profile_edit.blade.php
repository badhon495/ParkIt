@extends('layouts.app')
@section('title', 'Update Profile | ParkIt')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 4px rgba(0,0,0,0.06);max-width:400px;width:100%;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:1.5rem;">Update Profile</h2>
        <form method="POST" action="{{ isset($admin_user) ? url('/admin/users/' . $admin_user->id . '/edit') : '/profile/edit' }}" style="display:flex;flex-direction:column;gap:1rem;">
            @csrf
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $admin_user->name ?? session('user_name')) }}" placeholder="Name" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $admin_user->phone ?? session('user_phone')) }}" placeholder="Phone Number" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $admin_user->email ?? session('user_email')) }}" placeholder="Email" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            @if(isset($admin_user))
                <label for="type">Role</label>
                <select id="type" name="type" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                    <option value="user" {{ $admin_user->type == 'user' ? 'selected' : '' }}>User</option>
                    <option value="owner" {{ $admin_user->type == 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="admin" {{ $admin_user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="New Password (leave blank if not changing)" style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                <label for="new_password_confirmation">Confirm New Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm New Password" style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            @else
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" placeholder="Current Password (leave blank if not changing)" style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="New Password" style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                <label for="new_password_confirmation">Confirm New Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm New Password" style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
            @endif
            <button type="submit" style="background:#444;color:#fff;padding:0.5rem 0;border:none;border-radius:3px;font-size:1rem;font-weight:600;">Update</button>
        </form>
        @if(isset($admin_user))
        <form method="POST" action="{{ url('/admin/users/' . $admin_user->id . '/delete') }}" onsubmit="return confirm('Are you sure you want to delete this user?');" style="margin-top:1.5rem;">
            @csrf
            <button type="submit" style="background:#e53e3e;color:#fff;padding:0.5rem 0;width:100%;border:none;border-radius:3px;font-size:1rem;font-weight:600;">Delete User</button>
        </form>
        @endif
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
    </div>
</main>
@endsection
