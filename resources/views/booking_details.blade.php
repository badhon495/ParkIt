@extends('layouts.app')
@section('title', 'Garage Booking Details')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2.5rem 2rem 2rem 2rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:420px;width:100%;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:2rem;">Just a Few Steps to Your Garage Booking</h2>
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
                    <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                        <label>Phone Number (Unlock after Order)</label>
                        <input type="text" value="{{ $owner->phone ?? '' }}" placeholder="Phone Number (Unlock after Order)" readonly>
                    </div>
                    <div style="flex:1;display:flex;flex-direction:column;gap:0.3rem;">
                        <label>Email (Unlock After Order)</label>
                        <input type="email" value="{{ $owner->email ?? '' }}" placeholder="Email (Unlock After Order)" readonly>
                    </div>
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
@php
    $disabledDates = [];
    $disabledTimes = [];
    foreach ($bookedSlots as $slot) {
        $disabledDates[] = $slot->booking_date;
        $disabledTimes[$slot->booking_date][] = [
            'start' => $slot->start_time,
            'end' => $slot->end_time
        ];
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
        // Disable overlapping time slots for the selected date
        var disabledTimes = @json($disabledTimes);
        var startTimeInput = document.getElementsByName('start_time')[0];
        var endTimeInput = document.getElementsByName('end_time')[0];
        function updateTimeSlotWarnings(selectedDate) {
            if (!startTimeInput || !endTimeInput) return;
            var slots = disabledTimes[selectedDate] || [];
            // Remove previous warning if any
            let warning = document.getElementById('time-slot-warning');
            if (warning) warning.remove();
            // If there are slots, show a warning
            if (slots.length > 0) {
                let msg = 'Unavailable time slots for this date:';
                slots.forEach(function(slot) {
                    msg += `\n${slot.start} - ${slot.end}`;
                });
                let div = document.createElement('div');
                div.id = 'time-slot-warning';
                div.style.color = 'red';
                div.style.marginTop = '0.5rem';
                div.style.fontSize = '0.98rem';
                div.textContent = msg;
                // Insert after endTimeInput
                endTimeInput.parentNode.parentNode.appendChild(div);
            }
        }
        // Also update on page load if a date is pre-selected
        if (bookingDateInput && bookingDateInput.value) {
            updateTimeSlotWarnings(bookingDateInput.value);
        }
    });
</script>
@endsection
