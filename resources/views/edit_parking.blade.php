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
            <!-- Time Slots Multi-Select -->
            <div style="display:flex;flex-direction:column;gap:0.3rem;">
                <label for="slots">Available Time Slots <span style="color:red;">*</span></label>
                <div id="slots" style="display:flex;flex-wrap:wrap;gap:0.5rem 1.5rem;">
                    @php
                        $selectedSlots = old('slots', isset($garage->slots) ? json_decode($garage->slots, true) : []);
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
            <!-- Photos Button and Modal -->
            <div style="text-align:center; margin-top:1rem;">
                <button type="button" id="openPhotosModal" style="background:#3498db;color:#fff;padding:0.5rem 1.2rem;border:none;border-radius:3px;font-size:1rem;font-weight:600;min-width:120px;cursor:pointer;">Photos</button>
            </div>
            <button type="submit" style="background:#444;color:#fff;padding:0.5rem 0;border:none;border-radius:3px;font-size:1rem;font-weight:600;">Update</button>
        </form>
        <!-- Modal -->
        <div id="photosModal" style="display:none;position:fixed;z-index:1000;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.35);align-items:center;justify-content:center;">
            <div style="background:#fff;padding:2rem 2.5rem;border-radius:0.5rem;max-width:600px;width:95vw;max-height:90vh;overflow-y:auto;position:relative;">
                <button type="button" id="closePhotosModal" style="position:absolute;top:10px;right:10px;background:#e74c3c;color:#fff;border:none;border-radius:50%;width:32px;height:32px;font-size:1.2rem;">&times;</button>
                <h3 style="margin-bottom:1.2rem;text-align:center;">Garage Photos</h3>
                <form method="POST" action="/edit-parking/{{ $garage->garage_id }}/remove-images" id="deletePhotosForm">
                    @csrf
                    <div style="display:flex;flex-wrap:wrap;gap:1.5rem;justify-content:center;">
                        @php
                            $images = $garage->images ? json_decode($garage->images, true) : [];
                        @endphp
                        @forelse($images as $img)
                            <div style="display:flex;flex-direction:column;align-items:center;gap:0.5rem;">
                                <img src="{{ asset('storage/' . $img) }}" alt="Garage Image" style="width:110px;height:110px;object-fit:cover;border-radius:6px;border:1px solid #ccc;">
                                <input type="checkbox" name="images[]" value="{{ $img }}">
                            </div>
                        @empty
                            <div style="color:#888;">No images uploaded.</div>
                        @endforelse
                    </div>
                    <div style="margin-top:1.5rem;text-align:center;">
                        <button type="submit" style="background:#e74c3c;color:#fff;padding:0.5rem 1.5rem;border:none;border-radius:3px;font-size:1rem;font-weight:600;">Delete Selected</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.getElementById('openPhotosModal').onclick = function() {
                document.getElementById('photosModal').style.display = 'flex';
            };
            document.getElementById('closePhotosModal').onclick = function() {
                document.getElementById('photosModal').style.display = 'none';
            };
            // Close modal on outside click
            document.getElementById('photosModal').onclick = function(e) {
                if (e.target === this) this.style.display = 'none';
            };
        </script>
        <div style="text-align:center;margin-top:2.5rem;">
            <h3>Questions about garage update?</h3>
            <p>Call 01533024242</p>
        </div>
    </div>
</main>
@endsection
