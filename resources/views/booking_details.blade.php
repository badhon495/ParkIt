@extends('layouts.app')
@section('title', 'Garage Booking Details')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="display:flex;flex:1;max-width:1100px;width:100%;gap:2rem;">
        <div style="flex:1;display:flex;align-items:center;justify-content:center;">
            <h2 style="font-size:2.5rem;font-weight:700;color:#444;line-height:1.1;text-align:center;">Just a Few Steps to Your Garage Booking</h2>
        </div>
        <div style="flex:1;max-width:540px;margin:auto;">
            <div style="background:#fff;padding:3.5rem 2.5rem 2.5rem 2.5rem;border-radius:0.7rem;box-shadow:0 1px 12px rgba(0,0,0,0.13);width:100%;min-width:370px;">
                @if(session('success'))
                    <div class="alert alert-success" style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 1rem 2rem; border-radius: 6px; text-align: center; min-width: 300px; margin-bottom:1rem;">
                        {{ session('success') }}
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
                <form method="POST" action="/booking-details/{{ $garage->garage_id }}">
                    @csrf
                    <div style="display:flex;flex-direction:column;gap:1.2rem;">
                        <div style="display:flex;flex-direction:column;gap:0.3rem;">
                            <label>Garage Owner Name</label>
                            <input type="text" value="{{ $owner->name ?? '' }}" placeholder="Garage Owner Name" readonly>
                        </div>
                        <div style="display:flex;gap:1rem;">
                            <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                                <label>Division</label>
                                <input type="text" value="{{ $garage->division }}" placeholder="Division" readonly>
                            </div>
                            <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                                <label>Area</label>
                                <input type="text" value="{{ $garage->area }}" placeholder="Area" readonly>
                            </div>
                        </div>
                        <div style="display:flex;gap:1rem;">
                            <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;"></div>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:0.3rem;">
                            <label>Address in Details</label>
                            <input type="text" value="{{ $garage->location }}" placeholder="Address in Details" readonly>
                        </div>
                        <div style="display:flex;gap:0.7rem;flex-wrap:wrap;">
                            <div style="flex:1 1 160px;display:flex;flex-direction:column;gap:0.3rem;min-width:140px;">
                                <label>CC Camera</label>
                                <input type="text" value="{{ $garage->camera ? 'Yes' : 'No' }}" placeholder="CC Camera" readonly>
                            </div>
                            <div style="flex:1 1 160px;display:flex;flex-direction:column;gap:0.3rem;min-width:140px;">
                                <label>Guard</label>
                                <input type="text" value="{{ $garage->guard ? 'Yes' : 'No' }}" placeholder="Guard" readonly>
                            </div>
                            <div style="flex:1 1 160px;display:flex;flex-direction:column;gap:0.3rem;min-width:140px;">
                                <label>Indoor</label>
                                <input type="text" value="{{ ucfirst($garage->indoor) }}" placeholder="Indoor" readonly>
                            </div>
                            <div style="flex:1 1 160px;display:flex;flex-direction:column;gap:0.3rem;min-width:140px;">
                                <label>Place Type</label>
                                <input type="text" value="{{ ucfirst($garage->parking_type) }}" placeholder="Place Type" readonly>
                            </div>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:0.3rem;">
                            <label for="driver_name">Driver Name</label>
                            <input type="text" name="driver_name" id="driver_name" value="{{ old('driver_name') }}" placeholder="Driver Name" required>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:0.3rem;">
                            <label for="driver_phone">Driver Phone Number</label>
                            <input type="text" name="driver_phone" id="driver_phone" value="{{ old('driver_phone') }}" placeholder="Driver Phone Number" required>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:0.3rem;">
                            <label for="vehicle_details">Vehicle Details</label>
                            <input type="text" name="vehicle_details" id="vehicle_details" value="{{ old('vehicle_details') }}" placeholder="Vehicle Details" required>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:0.3rem;">
                            <label for="booking_date">Booking Date <span style="color:red;">*</span></label>
                            <input type="date" name="booking_date" id="booking_date" required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;">
                        </div>
                        <div style="display:flex;flex-direction:column;gap:0.3rem;">
                            <label for="booking_slots">Select Booking Slot(s) <span style="color:red;">*</span></label>
                            <select name="booking_slots[]" id="booking_slots" multiple required style="padding:0.5rem 0.75rem;border:1px solid #aaa;border-radius:3px;min-height:90px;">
                                {{-- Options will be dynamically populated by JS --}}
                            </select>
                            <small style="color:#888;">Hold Ctrl (Windows) or Cmd (Mac) to select multiple slots.</small>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:0.3rem;">
                            <label for="vehicle_type">Vehicle Type</label>
                            <select name="vehicle_type" id="vehicle_type" required>
                                <option value="">Select Vehicle Type</option>
                                <option value="Car" {{ old('vehicle_type') == 'Car' ? 'selected' : '' }}>Car</option>
                                <option value="Bike" {{ old('vehicle_type') == 'Bike' ? 'selected' : '' }}>Bike</option>
                                <option value="Bicycle" {{ old('vehicle_type') == 'Bicycle' ? 'selected' : '' }}>Bicycle</option>
                            </select>
                        </div>
                        <div style="display:flex;gap:1rem;">
                            <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                                <label for="owner_name">Owner Name</label>
                                <input type="text" name="owner_name" id="owner_name" value="{{ session('user_name') }}" placeholder="Owner Name" readonly>
                            </div>
                            <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                                <label for="owner_phone">Owner Phone Number</label>
                                <input type="text" name="owner_phone" id="owner_phone" value="{{ session('user_phone') }}" placeholder="Owner Phone Number" readonly>
                            </div>
                        </div>
                        <div style="margin-top:1.5rem;text-align:center;">
                            <button type="button" id="openPhotosModal" style="background:#3498db;color:#fff;padding:0.5rem 1.2rem;border:none;border-radius:3px;font-size:1rem;font-weight:600;min-width:120px;cursor:pointer;">Garage Photos</button>
                        </div>
                        <!-- Modal for Garage Photos -->
                        <div id="photosModal" style="display:none;position:fixed;z-index:1000;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.35);align-items:center;justify-content:center;">
                            <div style="background:#fff;padding:2rem 2.5rem;border-radius:0.5rem;max-width:600px;width:95vw;max-height:90vh;overflow-y:auto;position:relative;">
                                <button type="button" id="closePhotosModal" style="position:absolute;top:10px;right:10px;background:#e74c3c;color:#fff;border:none;border-radius:50%;width:32px;height:32px;font-size:1.2rem;">&times;</button>
                                <h3 style="margin-bottom:1.2rem;text-align:center;">Garage Photos</h3>
                                <div style="display:flex;flex-wrap:wrap;gap:1.5rem;justify-content:center;">
                                    @php
                                        $images = $garage->images ? json_decode($garage->images, true) : [];
                                    @endphp
                                    @forelse($images as $img)
                                        <div style="display:flex;flex-direction:column;align-items:center;gap:0.5rem;">
                                            <img src="{{ asset('storage/' . $img) }}" alt="Garage Image" style="width:110px;height:110px;object-fit:cover;border-radius:6px;border:1px solid #ccc;">
                                        </div>
                                    @empty
                                        <div style="color:#888;">No images uploaded.</div>
                                    @endforelse
                                </div>
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
        </div>
    </div>
</main>
@php
    $disabledDates = [];
    foreach ($bookedSlots as $slot) {
        $allSlots = isset($garage->slots) ? json_decode($garage->slots, true) : range(0,23);
        $slotArr = json_decode($slot->booked_slots, true);
        if (is_array($slotArr) && count($slotArr) >= count($allSlots)) {
            $disabledDates[] = $slot->booking_date;
        }
    }
    $disabledTimes = [];
    foreach ($bookedSlots as $slot) {
        $slotArr = json_decode($slot->booked_slots, true);
        if (is_array($slotArr)) {
            $disabledTimes[$slot->booking_date] = $slotArr;
        } else {
            $disabledTimes[$slot->booking_date] = [];
        }
    }
@endphp
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Disable already booked dates in the date picker
        var disabledDates = @json($disabledDates);
        var bookingDateInput = document.getElementById('booking_date');
        if (bookingDateInput) {
            bookingDateInput.addEventListener('input', function() {
                var selected = this.value;
                if (disabledDates.includes(selected)) {
                    this.setCustomValidity('This date is already fully booked. Please choose another date.');
                } else {
                    this.setCustomValidity('');
                }
            });
            bookingDateInput.addEventListener('change', function() {
                var selected = this.value;
                if (disabledDates.includes(selected)) {
                    this.setCustomValidity('This date is already fully booked. Please choose another date.');
                } else {
                    this.setCustomValidity('');
                }
                // Show/hide unavailable time slots for the selected date
                updateTimeSlotWarnings(selected);
            });
        }
        // --- Slot selection logic ---
        const bookingSlotsSelect = document.getElementById('booking_slots');
        // All possible slots for this garage
        const allSlots = @json(isset($garage->slots) ? json_decode($garage->slots, true) : []);
        // Booked slots by date
        const bookedSlotsByDate = {};
        @foreach($bookedSlots as $slot)
            bookedSlotsByDate['{{ $slot->booking_date }}'] = Array.isArray(@json(json_decode($slot->booked_slots, true))) ? @json(json_decode($slot->booked_slots, true)) : [];
        @endforeach
        function slotLabel(slot) {
            // slot is int hour (0-23) or string
            if (!isNaN(slot)) {
                const start = String(slot).padStart(2, '0') + ':00';
                const end = String((parseInt(slot)+1)%24).padStart(2, '0') + ':00';
                return `${start} - ${end}`;
            }
            return slot;
        }
        function updateSlotOptions(date) {
            bookingSlotsSelect.innerHTML = '';
            if (!date) return;
            let booked = bookedSlotsByDate[date] || [];
            let available = allSlots.filter(slot => !booked.includes(String(slot)) && !booked.includes(Number(slot)));
            if (available.length === 0) {
                let opt = document.createElement('option');
                opt.value = '';
                opt.textContent = 'No slots available for this date';
                opt.disabled = true;
                bookingSlotsSelect.appendChild(opt);
                return;
            }
            available.forEach(slot => {
                let opt = document.createElement('option');
                opt.value = slot;
                opt.textContent = slotLabel(slot);
                bookingSlotsSelect.appendChild(opt);
            });
        }
        if (bookingDateInput) {
            bookingDateInput.addEventListener('change', function() {
                updateSlotOptions(this.value);
            });
            // On page load, if date is pre-filled
            if (bookingDateInput.value) {
                updateSlotOptions(bookingDateInput.value);
            }
        }
    });
</script>
@endsection
