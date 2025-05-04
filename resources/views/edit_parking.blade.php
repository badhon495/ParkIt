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
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="owner_name">Owner Name</label>
                    <input type="text" name="owner_name" id="owner_name" placeholder="Ex - John Doe" required value="{{ old('owner_name', $user['name']) }}" readonly>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" placeholder="Ex - 017XXXXXXXX" required value="{{ old('phone', $user['phone']) }}" readonly>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Ex - johndoe@email.com" required value="{{ old('email', $user['email']) }}" readonly>
                </div>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="division">Division</label>
                    <select name="division" id="division" required>
                        <option value="">Division</option>
                        <option value="Dhaka" {{ $garage->division == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                        <option value="Chittagong" {{ $garage->division == 'Chittagong' ? 'selected' : '' }}>Chittagong</option>
                    </select>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="area">Area</label>
                    <select name="area" id="area" required>
                        <option value="">Area</option>
                        <option value="adabor" {{ $garage->area == 'adabor' ? 'selected' : '' }}>Adabor</option>
                        <option value="badda" {{ $garage->area == 'badda' ? 'selected' : '' }}>Badda</option>
                        <option value="mohakhali" {{ $garage->area == 'mohakhali' ? 'selected' : '' }}>Mohakhali</option>
                    </select>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label for="address">Address in Details</label>
                <input type="text" name="address" id="address" placeholder="Ex - House 12, Road 3, Dhanmondi, Dhaka" required value="{{ old('address', $garage->location) }}">
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="cc_camera">CC Camera</label>
                    <select name="cc_camera" id="cc_camera" required>
                        <option value="">CC Camera</option>
                        <option value="1" {{ $garage->camera ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$garage->camera ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="guard">Guard</label>
                    <select name="guard" id="guard" required>
                        <option value="">Guard</option>
                        <option value="1" {{ $garage->guard ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$garage->guard ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="indoor">Indoor/Outdoor</label>
                    <select name="indoor" id="indoor" required>
                        <option value="">Indoor/Outdoor</option>
                        <option value="indoor" {{ (old('indoor', $garage->indoor) == 'indoor') ? 'selected' : '' }}>Indoor</option>
                        <option value="outdoor" {{ (old('indoor', $garage->indoor) == 'outdoor') ? 'selected' : '' }}>Outdoor</option>
                    </select>
                </div>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="bike_slot">Bike Slot</label>
                    <input type="number" name="bike_slot" id="bike_slot" placeholder="Ex - 5" value="{{ old('bike_slot', $garage->bike_slot) }}">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="car_slot">Car Slot</label>
                    <input type="number" name="car_slot" id="car_slot" placeholder="Ex - 2" value="{{ old('car_slot', $garage->car_slot) }}">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="bicycle_slot">Bicycle Slot</label>
                    <input type="number" name="bicycle_slot" id="bicycle_slot" placeholder="Ex - 3" value="{{ old('bicycle_slot', $garage->bicycle_slot) }}">
                </div>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="start_time">Start Time</label>
                    <input type="text" name="start_time" id="start_time" required placeholder="Ex - 08:00" value="{{ old('start_time', $garage->start_time) }}">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="end_time">End Time</label>
                    <input type="text" name="end_time" id="end_time" required placeholder="Ex - 22:00" value="{{ old('end_time', $garage->end_time) }}">
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label for="place_type">Place Type</label>
                <select name="place_type" id="place_type" required>
                    <option value="">Place Type</option>
                    <option value="residential" {{ $garage->parking_type == 'residential' ? 'selected' : '' }}>Residential</option>
                    <option value="market" {{ $garage->parking_type == 'market' ? 'selected' : '' }}>Market</option>
                </select>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="nid">NID</label>
                    <input type="text" name="nid" id="nid" placeholder="Ex - 1234567890" required value="{{ old('nid', $garage->nid) }}">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="customer_id">Customer ID (Utility Bill)</label>
                    <input type="text" name="customer_id" id="customer_id" placeholder="Ex - 987654321" required value="{{ old('customer_id', $garage->utility_bill) }}">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="passport">Passport</label>
                    <input type="text" name="passport" id="passport" placeholder="Ex - AB1234567" value="{{ old('passport', $garage->passport) }}">
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label for="rent">Rent (required)</label>
                <input type="number" name="rent" id="rent" placeholder="Ex - 200" required min="0" step="0.01" value="{{ old('rent', $garage->rent) }}">
            </div>
            <div style="display:flex;gap:1rem;align-items:center;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="nid_photo">Upload Photo of NID</label>
                    <input type="file" name="nid_photo" id="nid_photo" accept="image/*">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="bill_photo">Upload Photo of Bill</label>
                    <input type="file" name="bill_photo" id="bill_photo" accept="image/*">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="passport_photo">Upload Photo of Passport</label>
                    <input type="file" name="passport_photo" id="passport_photo" accept="image/*">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="garage_photos">Upload Photo(s) of Garage</label>
                    <input type="file" name="garage_photos[]" id="garage_photos" accept="image/*" multiple>
                </div>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="payment_method">Payment Method</label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="">Payment Method</option>
                        <option value="BKash" {{ (old('payment_method', $garage->payment_method) == 'BKash') ? 'selected' : '' }}>BKash</option>
                        <option value="Bank" {{ (old('payment_method', $garage->payment_method) == 'Bank') ? 'selected' : '' }}>Bank</option>
                    </select>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="bank_details">Bank Details</label>
                    <input type="text" name="bank_details" id="bank_details" placeholder="Ex - Bank Asia, A/C: 1234567890" value="{{ old('bank_details', $garage->bank_details) }}">
                </div>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="alternate_person_name">Name of alternate person to contract</label>
                    <input type="text" name="alternate_person_name" id="alternate_person_name" placeholder="Ex - Jane Doe" value="{{ old('alternate_person_name', $garage->alt_name) }}">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="alternate_person_phone">Phone no of alternate person to contract</label>
                    <input type="text" name="alternate_person_phone" id="alternate_person_phone" placeholder="Ex - 018XXXXXXXX" value="{{ old('alternate_person_phone', $garage->alt_phone) }}">
                </div>
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
