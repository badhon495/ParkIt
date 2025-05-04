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
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="owner_name">Owner Name</label>
                    <input type="text" id="owner_name" name="owner_name" placeholder="Ex - John Doe" required value="{{ old('owner_name', $user['name']) }}">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="Ex - 017XXXXXXXX" required value="{{ old('phone', $user['phone']) }}">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Ex - johndoe@email.com" required value="{{ old('email', $user['email']) }}">
                </div>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="division">Division</label>
                    <select name="division" id="division" required>
                        <option value="">Division</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Chittagong">Chittagong</option>
                    </select>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="area">Area</label>
                    <select name="area" id="area" required>
                        <option value="">Area</option>
                        <option value="adabor">Adabor</option>
                        <option value="badda">Badda</option>
                        <option value="mohakhali">Mohakhali</option>
                    </select>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label for="address">Address in Details</label>
                <input type="text" id="address" name="address" placeholder="Ex - House 12, Road 3, Dhanmondi, Dhaka" required>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="cc_camera">CC Camera</label>
                    <select name="cc_camera" id="cc_camera" required>
                        <option value="">CC Camera</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="guard">Guard</label>
                    <select name="guard" id="guard" required>
                        <option value="">Guard</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="indoor">Indoor/Outdoor</label>
                    <select name="indoor" id="indoor" required>
                        <option value="">Indoor/Outdoor</option>
                        <option value="indoor">Indoor</option>
                        <option value="outdoor">Outdoor</option>
                    </select>
                </div>
            </div>
            <!-- Time Slots Multi-Select -->
            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label for="slots">Available Time Slots <span style="color:red;">*</span></label>
                <div id="slots" style="display:flex;flex-wrap:wrap;gap:0.5rem 1.5rem;">
                    @php
                        $selectedSlots = old('slots', []);
                    @endphp
                    @for ($i = 0; $i < 24; $i++)
                        <div style="min-width:120px;">
                            <input type="checkbox" name="slots[]" id="slot_{{ $i }}" value="{{ $i }}" {{ is_array($selectedSlots) && in_array($i, $selectedSlots) ? 'checked' : '' }}>
                            <label for="slot_{{ $i }}">
                                {{ sprintf('%02d:00', $i) }} - {{ sprintf('%02d:00', ($i+1)%24) }}
                            </label>
                        </div>
                    @endfor
                </div>
                <small style="color:#888;">Select all one-hour slots when your garage is available for booking. (e.g., 08:00-09:00 means slot 8)</small>
            </div>
            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label for="place_type">Place Type</label>
                <select name="place_type" id="place_type" required>
                    <option value="">Place Type</option>
                    <option value="residential">Residential</option>
                    <option value="market">Market</option>
                </select>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="nid">NID</label>
                    <input type="text" id="nid" name="nid" placeholder="Ex - 1234567890" required>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="customer_id">Customer ID (Utility Bill)</label>
                    <input type="text" id="customer_id" name="customer_id" placeholder="Ex - 987654321" required>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="passport">Passport</label>
                    <input type="text" id="passport" name="passport" placeholder="Ex - AB1234567">
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label for="rent">Rent (required)</label>
                <input type="number" id="rent" name="rent" placeholder="Ex - 200" required min="0" step="0.01">
            </div>
            <div style="display:flex;gap:1rem;align-items:center;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="nid_photo">Upload Photo of NID</label>
                    <input type="file" id="nid_photo" name="nid_photo" accept="image/*" required>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="bill_photo">Upload Photo of Bill</label>
                    <input type="file" id="bill_photo" name="bill_photo" accept="image/*" required>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="passport_photo">Upload Photo of Passport</label>
                    <input type="file" id="passport_photo" name="passport_photo" accept="image/*">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="garage_photos">Upload Photo of Garage</label>
                    <input type="file" id="garage_photos" name="garage_photos[]" accept="image/*" multiple required>
                </div>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="payment_method">Payment Method</label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="">Payment Method</option>
                        <option value="BKash">BKash</option>
                        <option value="Bank">Bank</option>
                    </select>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="bank_details">Bank Details</label>
                    <input type="text" id="bank_details" name="bank_details" placeholder="Ex - Bank Asia, A/C: 1234567890">
                </div>
            </div>
            <div style="display:flex;gap:1rem;">
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="alternate_person_name">Name of alternate person to contract</label>
                    <input type="text" id="alternate_person_name" name="alternate_person_name" placeholder="Ex - Jane Doe">
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                    <label for="alternate_person_phone">Phone no of alternate person to contract</label>
                    <input type="text" id="alternate_person_phone" name="alternate_person_phone" placeholder="Ex - 018XXXXXXXX">
                </div>
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
