@extends('layouts.app')
@section('title', 'Parking List | ParkIt')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2.5rem 2.5rem 2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:1100px;width:100%;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:2rem;">Parking List</h2>
        <form method="GET" action="" style="margin-bottom:2rem;display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;align-items:center;">
            <select name="search_field" style="padding:0.5rem;">
                <option value="garage_id" {{ request('search_field') == 'garage_id' ? 'selected' : '' }}>Garage ID</option>
                <option value="area" {{ request('search_field') == 'area' ? 'selected' : '' }}>Area</option>
                <option value="division" {{ request('search_field') == 'division' ? 'selected' : '' }}>Division</option>
                <option value="nid" {{ request('search_field') == 'nid' ? 'selected' : '' }}>NID</option>
            </select>
            <input type="text" name="search_value" placeholder="Enter search value" value="{{ request('search_value') }}" style="padding:0.5rem;">
            <button type="submit" class="search-button">Search</button>
            <a href="{{ url()->current() }}" style="padding:0.5rem 1rem;background:#eee;border-radius:4px;text-decoration:none;">Reset</a>
        </form>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f3f3f3;">
                    <th style="padding:8px;">Garage ID</th>
                    <th style="padding:8px;">Owner ID</th>
                    <th style="padding:8px;">Owner Name</th>
                    <th style="padding:8px;">Phone</th>
                    <th style="padding:8px;">Area</th>
                    <th style="padding:8px;">Division</th>
                    <th style="padding:8px;">Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($garages as $garage)
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:8px;">{{ $garage->garage_id }}</td>
                    <td style="padding:8px;">{{ $garage->usr_id }}</td>
                    <td style="padding:8px;">{{ $garage->owner_name }}</td>
                    <td style="padding:8px;">{{ $garage->owner_phone }}</td>
                    <td style="padding:8px;">{{ $garage->area }}</td>
                    <td style="padding:8px;">{{ $garage->division }}</td>
                    <td style="padding:8px;"><a href="/admin/edit-parking/{{ $garage->garage_id }}" style="background:#444;color:#fff;padding:0.4rem 1rem;border-radius:3px;text-decoration:none;font-size:0.98rem;">Details</a></td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:16px;">No garages found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
