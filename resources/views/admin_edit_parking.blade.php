@extends('layouts.app')
@section('title', 'Edit Garage | ParkIt')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:3.5rem 4rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:900px;width:100%;">
        <h2 style="text-align:center;font-size:2.5rem;font-weight:700;color:#444;margin-bottom:2rem;">Edit Garage Details</h2>
        @if(session('success'))
            <div class="alert alert-success" style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 1rem 2rem; border-radius: 6px; text-align: center; min-width: 300px; margin-bottom:1rem;">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="" style="display:flex;flex-direction:column;gap:1.5rem;">
            @csrf
            <div style="display:flex;gap:1rem;">
                <input type="text" name="owner_name" value="{{ $owner->name ?? '-' }}" readonly style="flex:1;background:#f3f3f3;">
                <input type="text" name="owner_phone" value="{{ $owner->phone ?? '-' }}" readonly style="flex:1;background:#f3f3f3;">
            </div>
            <div style="display:flex;gap:1rem;">
                <select name="division" required style="flex:1;">
                    <option value="">Division</option>
                    <option value="Dhaka" {{ $garage->division == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                    <option value="Chittagong" {{ $garage->division == 'Chittagong' ? 'selected' : '' }}>Chittagong</option>
                </select>
                <input type="text" name="area" placeholder="Area" required style="flex:1;" value="{{ $garage->area }}">
            </div>
            <input type="text" name="location" placeholder="Address in Details" required value="{{ $garage->location }}">
            <div style="display:flex;gap:1rem;">
                <select name="camera" required style="flex:1;">
                    <option value="">CC Camera</option>
                    <option value="1" {{ $garage->camera ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$garage->camera ? 'selected' : '' }}>No</option>
                </select>
                <select name="guard" required style="flex:1;">
                    <option value="">Guard</option>
                    <option value="1" {{ $garage->guard ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$garage->guard ? 'selected' : '' }}>No</option>
                </select>
                <select name="indoor" required style="flex:1;">
                    <option value="">Indoor/Outdoor</option>
                    <option value="indoor" {{ $garage->indoor == 'indoor' ? 'selected' : '' }}>Indoor</option>
                    <option value="outdoor" {{ $garage->indoor == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                </select>
            </div>
            <div style="display:flex;gap:1rem;">
                <input type="number" name="bike_slot" placeholder="Bike Slot" value="{{ $garage->bike_slot }}">
                <input type="number" name="car_slot" placeholder="Car Slot" value="{{ $garage->car_slot }}">
                <input type="number" name="bicycle_slot" placeholder="Bicycle Slot" value="{{ $garage->bicycle_slot }}">
            </div>
            <div style="display:flex;gap:1rem;">
                <label style="flex:1;">
                    Start Time
                    <input type="text" name="start_time" required style="width:100%;" value="{{ $garage->start_time }}">
                </label>
                <label style="flex:1;">
                    End Time
                    <input type="text" name="end_time" required style="width:100%;" value="{{ $garage->end_time }}">
                </label>
            </div>
            <select name="parking_type" required>
                <option value="">Place Type</option>
                <option value="residential" {{ $garage->parking_type == 'residential' ? 'selected' : '' }}>Residential</option>
                <option value="market" {{ $garage->parking_type == 'market' ? 'selected' : '' }}>Market</option>
            </select>
            <input type="text" name="nid" placeholder="NID" required value="{{ $garage->nid }}">
            <input type="text" name="utility_bill" placeholder="Customer ID (Utility Bill)" required value="{{ $garage->utility_bill }}">
            <input type="text" name="passport" placeholder="Passport" value="{{ $garage->passport }}">
            <input type="number" name="rent" placeholder="Rent (required)" required min="0" step="0.01" value="{{ $garage->rent }}">
            <div style="display:flex;gap:1rem;align-items:center;">
                <input type="text" name="alt_name" placeholder="Name of alternate person to contract" style="flex:1;" value="{{ $garage->alt_name }}">
                <input type="text" name="alt_phone" placeholder="Phone no of alternate person to contract" style="flex:1;" value="{{ $garage->alt_phone }}">
            </div>
            <div style="display:flex;gap:1rem;">
                <select name="payment_method" required style="flex:1;">
                    <option value="">Payment Method</option>
                    <option value="BKash" {{ $garage->payment_method == 'BKash' ? 'selected' : '' }}>BKash</option>
                    <option value="Bank" {{ $garage->payment_method == 'Bank' ? 'selected' : '' }}>Bank</option>
                </select>
                <input type="text" name="bank_details" placeholder="Bank Details" style="flex:1;" value="{{ $garage->bank_details }}">
            </div>
            <button type="submit" style="background:#444;color:#fff;padding:0.5rem 0;border:none;border-radius:3px;font-size:1rem;font-weight:600;">Update</button>
        </form>
    </div>
</main>
@endsection
