@extends('layouts.app')
@section('title', 'Register Parking | ParkIt')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:3.5rem 4rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:900px;width:100%;">
        <h2 style="text-align:center;font-size:2.5rem;font-weight:700;color:#444;margin-bottom:2rem;">Your Garage, Our Platform.<br>Maximum Exposure</h2>
        @if (session('success'))
            <div style="margin-bottom:1rem; display: flex; justify-content: center;">
                <div class="alert alert-success" style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 1rem 2rem; border-radius: 6px; text-align: center; min-width: 300px;">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="/register-parking" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:1.5rem;" id="registerParkingForm">
            @csrf
            <input type="text" name="owner_name" placeholder="Owner Name" required value="{{ old('owner_name', $user['name']) }}">
            <div style="display:flex;gap:1rem;">
                <input type="text" name="phone" placeholder="Phone Number" required style="flex:1;" value="{{ old('phone', $user['phone']) }}">
                <input type="email" name="email" placeholder="Email" required style="flex:1;" value="{{ old('email', $user['email']) }}">
            </div>
            <div style="display:flex;gap:1rem;">
                <select name="division" required style="flex:1;">
                    <option value="">Division</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chittagong">Chittagong</option>
                </select>
                <select name="area" required style="flex:1;">
                    <option value="">Area</option>
                    <option value="adabor">Adabor</option>
                    <option value="badda">Badda</option>
                    <option value="mohakhali">Mohakhali</option>
                </select>
            </div>
            <input type="text" name="address" placeholder="Address in Details" required>
            <div style="display:flex;gap:1rem;">
                <select name="cc_camera" required style="flex:1;">
                    <option value="">CC Camera</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <select name="guard" required style="flex:1;">
                    <option value="">Guard</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <select name="indoor" required style="flex:1;">
                    <option value="">Indoor/Outdoor</option>
                    <option value="indoor">Indoor</option>
                    <option value="outdoor">Outdoor</option>
                </select>
            </div>
            <input type="number" name="bike_slot" placeholder="Bike Slot (Fillup this if you want to allow bikes)">
            <input type="number" name="car_slot" placeholder="Car Slot (Fillup this if you want to allow cars)">
            <input type="number" name="bicycle_slot" placeholder="Bicycle Slot (Fillup this if you want to allow bicycle)">
            <div style="display:flex;gap:1rem;">
                <label style="flex:1;">
                    Start Time
                    <input type="text" name="start_time" required style="width:100%;" placeholder="Select start time">
                </label>
                <label style="flex:1;">
                    End Time
                    <input type="text" name="end_time" required style="width:100%;" placeholder="Select end time">
                </label>
            </div>
            <select name="place_type" required>
                <option value="">Place Type</option>
                <option value="residential">Residential</option>
                <option value="market">Market</option>
            </select>
            <input type="text" name="nid" placeholder="NID" required>
            <input type="text" name="customer_id" placeholder="Customer ID (Utility Bill)" required>
            <input type="text" name="passport" placeholder="Passport">
            <input type="number" name="rent" placeholder="Rent (required)" required min="0" step="0.01">
            <div style="display:flex;gap:1rem;align-items:center;">
                <div style="flex:1;">
                    <label>Upload Photo of NID</label>
                    <input type="file" name="nid_photo" accept="image/*" required>
                </div>
                <div style="flex:1;">
                    <label>Upload Photo of Bill</label>
                    <input type="file" name="bill_photo" accept="image/*" required>
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
                    <option value="BKash">BKash</option>
                    <option value="Bank">Bank</option>
                </select>
                <input type="text" name="bank_details" placeholder="Bank Details" style="flex:1;">
            </div>
            <div style="display:flex;gap:1rem;">
                <input type="text" name="alternate_person_name" placeholder="Name of alternate person to contract" style="flex:1;">
                <input type="text" name="alternate_person_phone" placeholder="Phone no of alternate person to contract" style="flex:1;">
            </div>
            <button type="submit" style="background:#444;color:#fff;padding:0.5rem 0;border:none;border-radius:3px;font-size:1rem;font-weight:600;">Done</button>
        </form>
        <div style="text-align:center;margin-top:2.5rem;">
            <h3>Questions about garage registration?</h3>
            <p>Call 01533024242</p>
        </div>
    </div>
</main>
<script>
    // On successful registration, clear all fields except name, phone, email
    @if (session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('registerParkingForm');
        if (form) {
            var keep = ['owner_name', 'phone', 'email', '_token'];
            Array.from(form.elements).forEach(function(el) {
                if (el.name && !keep.includes(el.name)) {
                    if (el.type === 'checkbox' || el.type === 'radio') {
                        el.checked = false;
                    } else if (el.type === 'select-one' || el.type === 'select-multiple') {
                        el.selectedIndex = 0;
                    } else {
                        el.value = '';
                    }
                }
            });
        }
    });
    @endif
</script>
@endsection
