@extends('layouts.app')
@section('title', 'Garage Booking Details')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2.5rem 2.5rem 2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:700px;width:100%;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:2rem;">Just a Few Steps to Your Garage Booking</h2>
        <form method="POST" action="/booking-details/{{ $garage->garage_id }}">
            @csrf
            <div style="display:flex;flex-direction:column;gap:1.2rem;">
                <input type="text" value="{{ $owner->name ?? '' }}" placeholder="Garage Owner Name" readonly>
                <div style="display:flex;gap:1rem;">
                    <input type="text" value="{{ $garage->division }}" placeholder="Division" readonly style="flex:1;">
                    <input type="text" value="{{ $garage->area }}" placeholder="Area" readonly style="flex:1;">
                </div>
                <div style="display:flex;gap:1rem;">
                    <input type="text" value="{{ $owner->phone ?? '' }}" placeholder="Phone Number (Unlock after Order)" readonly style="flex:1;">
                    <input type="email" value="{{ $owner->email ?? '' }}" placeholder="Email (Unlock After Order)" readonly style="flex:1;">
                </div>
                <input type="text" value="{{ $garage->location }}" placeholder="Address in Details" readonly>
                <div style="display:flex;gap:1rem;">
                    <input type="text" value="{{ $garage->camera ? 'Yes' : 'No' }}" placeholder="CC Camera" readonly style="flex:1;">
                    <input type="text" value="{{ $garage->guard ? 'Yes' : 'No' }}" placeholder="Guard" readonly style="flex:1;">
                    <input type="text" value="{{ ucfirst($garage->indoor) }}" placeholder="Indoor" readonly style="flex:1;">
                    <input type="text" value="{{ ucfirst($garage->parking_type) }}" placeholder="Place Type" readonly style="flex:1;">
                </div>
                <input type="text" name="driver_name" value="{{ old('driver_name') }}" placeholder="Driver Name" required>
                <input type="text" name="driver_phone" value="{{ old('driver_phone') }}" placeholder="Driver Phone Number" required>
                <input type="text" name="vehicle_details" value="{{ old('vehicle_details') }}" placeholder="Vehicle Details" required>
                <div style="display:flex;gap:1rem;">
                    <label style="flex:1;">
                        Start Time
                        <input type="time" name="start_time" value="{{ old('start_time', $garage->start_time) }}" required style="width:100%;">
                    </label>
                    <label style="flex:1;">
                        End Time
                        <input type="time" name="end_time" value="{{ old('end_time', $garage->end_time) }}" required style="width:100%;">
                    </label>
                </div>
                <select name="vehicle_type" required>
                    <option value="">Select Vehicle Type</option>
                    <option value="Car" {{ old('vehicle_type') == 'Car' ? 'selected' : '' }}>Car</option>
                    <option value="Bike" {{ old('vehicle_type') == 'Bike' ? 'selected' : '' }}>Bike</option>
                    <option value="Bicycle" {{ old('vehicle_type') == 'Bicycle' ? 'selected' : '' }}>Bicycle</option>
                </select>
                <div style="display:flex;gap:1rem;">
                    <input type="text" name="owner_name" value="{{ session('user_name') }}" placeholder="Owner Name" readonly style="flex:1;">
                    <input type="text" name="owner_phone" value="{{ session('user_phone') }}" placeholder="Owner Phone Number" readonly style="flex:1;">
                </div>
                <div style="display:flex;justify-content:center;margin-top:1.5rem;">
                    <button class="search-button" style="font-size:1.1rem;padding:0.7rem 2.5rem;">Confirm Booking</button>
                </div>
                <div style="text-align:center;margin-top:2.5rem;">
                    <p style="font-size:0.95rem;color:#888;">By pressing confirm booking, you agree to our<br>Terms of Service and Privacy Policy.</p>
                </div>
            </div>
        </form>
        <div style="text-align:center;margin-top:2.5rem;">
            <h2 style="font-size:1.5rem;">Questions about garage booking?</h2>
            <p style="font-size:1.2rem;font-weight:600;">Call 01533024242</p>
        </div>
    </div>
</main>
@endsection
