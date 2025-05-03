@extends('layouts.app')
@section('title', 'Admin User List')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2.5rem 2.5rem 2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:1100px;width:100%;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:2rem;">All Users</h2>
        <form method="GET" action="" style="margin-bottom:1.5rem;display:flex;justify-content:center;gap:1rem;">
            <input type="text" name="search_id" placeholder="Search by User ID" value="{{ request('search_id') }}" style="padding:0.5rem 1rem;border-radius:4px;border:1px solid #ccc;">
            <button type="submit" class="search-button">Search</button>
        </form>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f3f3f3;">
                    <th style="padding:8px;">ID</th>
                    <th style="padding:8px;">Name</th>
                    <th style="padding:8px;">Type</th>
                    <th style="padding:8px;">Email</th>
                    <th style="padding:8px;">Phone</th>
                    <th style="padding:8px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="padding:8px;">{{ $user->id }}</td>
                        <td style="padding:8px;">{{ $user->name }}</td>
                        <td style="padding:8px;">{{ isset($user->type) ? ucfirst($user->type) : '' }}</td>
                        <td style="padding:8px;">{{ $user->email }}</td>
                        <td style="padding:8px;">{{ $user->phone ?? '' }}</td>
                        <td style="padding:8px;">
                            <a href="/admin/users/{{ $user->id }}/edit" class="search-button" style="padding:4px 12px;">Update</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
