@extends('layouts.app')
@section('title', 'Edit Garage | ParkIt')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:3.5rem 4rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:900px;width:100%;">
        <h2 style="text-align:center;font-size:2.5rem;font-weight:700;color:#444;margin-bottom:2rem;">Edit Your Garage Details</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="/edit-parking/{{ $garage->garage_id }}" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:1.5rem;">
            @csrf
            <input type="text" name="owner_name" placeholder="Owner Name" required value="{{ old('owner_name', $user['name']) }}" readonly>
            <div style="display:flex;gap:1rem;">
                <input type="text" name="phone" placeholder="Phone Number" required style="flex:1;" value="{{ old('phone', $user['phone']) }}" readonly>
                <input type="email" name="email" placeholder="Email" required style="flex:1;" value="{{ old('email', $user['email']) }}" readonly>
            </div>
            <div style="display:flex;gap:1rem;">
                <select name="division" required style="flex:1;">
                    <option value="">Division</option>
                    <option value="Dhaka" {{ $garage->division == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                    <option value="Chittagong" {{ $garage->division == 'Chittagong' ? 'selected' : '' }}>Chittagong</option>
                </select>
                <select name="area" required style="flex:1;">
                    <option value="">Area</option>
                    <option value="adabor" {{ $garage->area == 'adabor' ? 'selected' : '' }}>Adabor</option>
                    <option value="badda" {{ $garage->area == 'badda' ? 'selected' : '' }}>Badda</option>
                    <option value="mohakhali" {{ $garage->area == 'mohakhali' ? 'selected' : '' }}>Mohakhali</option>
                </select>
            </div>
            <input type="text" name="address" placeholder="Address in Details" required value="{{ old('address', $garage->location) }}">
            <div style="display:flex;gap:1rem;">
                <select name="cc_camera" required style="flex:1;">
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
                    <option value="indoor" {{ (old('indoor', $garage->indoor) == 'indoor') ? 'selected' : '' }}>Indoor</option>
                    <option value="outdoor" {{ (old('indoor', $garage->indoor) == 'outdoor') ? 'selected' : '' }}>Outdoor</option>
                </select>
            </div>
            <input type="number" name="bike_slot" placeholder="Bike Slot" value="{{ old('bike_slot', $garage->bike_slot) }}">
            <input type="number" name="car_slot" placeholder="Car Slot" value="{{ old('car_slot', $garage->car_slot) }}">
            <input type="number" name="bicycle_slot" placeholder="Bicycle Slot" value="{{ old('bicycle_slot', $garage->bicycle_slot) }}">
            <div style="display:flex;gap:1rem;">
                <label style="flex:1;">
                    Start Time
                    <input type="text" name="start_time" required style="width:100%;" value="{{ old('start_time', $garage->start_time) }}">
                </label>
                <label style="flex:1;">
                    End Time
                    <input type="text" name="end_time" required style="width:100%;" value="{{ old('end_time', $garage->end_time) }}">
                </label>
            </div>
            <select name="place_type" required>
                <option value="">Place Type</option>
                <option value="residential" {{ $garage->parking_type == 'residential' ? 'selected' : '' }}>Residential</option>
                <option value="market" {{ $garage->parking_type == 'market' ? 'selected' : '' }}>Market</option>
            </select>
            <input type="text" name="nid" placeholder="NID" required value="{{ old('nid', $garage->nid) }}">
            <input type="text" name="customer_id" placeholder="Customer ID (Utility Bill)" required value="{{ old('customer_id', $garage->utility_bill) }}">
            <input type="text" name="passport" placeholder="Passport" value="{{ old('passport', $garage->passport) }}">
            <input type="number" name="rent" placeholder="Rent (required)" required min="0" step="0.01" value="{{ old('rent', $garage->rent) }}">
            <div style="display:flex;gap:1rem;align-items:center;">
                <div style="flex:1;">
                    <label>Upload Photo of NID</label>
                    <input type="file" name="nid_photo" accept="image/*">
                </div>
                <div style="flex:1;">
                    <label>Upload Photo of Bill</label>
                    <input type="file" name="bill_photo" accept="image/*">
                </div>
                <div style="flex:1;">
                    <label>Upload Photo of Passport</label>
                    <input type="file" name="passport_photo" accept="image/*">
                </div>
                <div style="flex:1;">
                    <label>Upload Photo(s) of Garage</label>
                    <input type="file" name="garage_photos[]" accept="image/*" multiple>
                </div>
            </div>
            <div style="display:flex;gap:1rem;">
                <select name="payment_method" required style="flex:1;">
                    <option value="">Payment Method</option>
                    <option value="BKash" {{ (old('payment_method', $garage->payment_method) == 'BKash') ? 'selected' : '' }}>BKash</option>
                    <option value="Bank" {{ (old('payment_method', $garage->payment_method) == 'Bank') ? 'selected' : '' }}>Bank</option>
                </select>
                <input type="text" name="bank_details" placeholder="Bank Details" style="flex:1;" value="{{ old('bank_details', $garage->bank_details) }}">
            </div>
            <div style="display:flex;gap:1rem;">
                <input type="text" name="alternate_person_name" placeholder="Name of alternate person to contract" style="flex:1;" value="{{ old('alternate_person_name', $garage->alt_name) }}">
                <input type="text" name="alternate_person_phone" placeholder="Phone no of alternate person to contract" style="flex:1;" value="{{ old('alternate_person_phone', $garage->alt_phone) }}">
            </div>
            <button type="submit" style="background:#444;color:#fff;padding:0.5rem 0;border:none;border-radius:3px;font-size:1rem;font-weight:600;">Update</button>
        </form>
        <div style="text-align:center;margin-top:2.5rem;">
            <h3>Questions about garage update?</h3>
            <p>Call 01533024242</p>
        </div>
    </div>
</main>
@endsection
