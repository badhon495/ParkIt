@extends('layouts.app')
@section('title', 'Admin Bookings')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2.5rem 2.5rem 2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:1100px;width:100%;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:2rem;">All Bookings</h2>
        <form method="GET" action="" style="margin-bottom:1.5rem;display:flex;justify-content:center;gap:1rem;">
            <input type="text" name="search_id" placeholder="Search by Booking ID" value="{{ request('search_id') }}" style="padding:0.5rem 1rem;border-radius:4px;border:1px solid #ccc;">
            <button type="submit" class="search-button">Search</button>
        </form>
        @if(session('success'))
            <div class="alert alert-success" style="text-align:center;margin-bottom:1rem;">{{ session('success') }}</div>
        @endif
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f3f3f3;">
                    <th style="padding:8px;">ID</th>
                    <th style="padding:8px;">Image</th>
                    <th style="padding:8px;">Area</th>
                    <th style="padding:8px;">Type</th>
                    <th style="padding:8px;">Rent/hr</th>
                    <th style="padding:8px;">Booking Date</th>
                    <th style="padding:8px;">Booked Slots</th>
                    <th style="padding:8px;">Vehicle</th>
                    <th style="padding:8px;">Driver</th>
                    <th style="padding:8px;">Edit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td style="padding:8px;">{{ $booking->booking_id }}</td>
                        <td style="padding:8px;">
                            @php
                                $images = $booking->images ? json_decode($booking->images, true) : [];
                                $firstImage = !empty($images) ? $images[0] : null;
                            @endphp
                            @if($firstImage)
                                <img src="{{ asset('storage/' . $firstImage) }}" alt="Garage Image" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                            @else
                                <span style="color:#888;">No Image</span>
                            @endif
                        </td>
                        <td style="padding:8px;">{{ $booking->area }}</td>
                        <td style="padding:8px;">{{ ucfirst($booking->parking_type) }}</td>
                        <td style="padding:8px;">{{ $booking->rent }}</td>
                        <td style="padding:8px;">{{ $booking->booking_date ?? '-' }}</td>
                        <td style="padding:8px;">
                            @php
                                $slots = isset($booking->booked_slots) ? json_decode($booking->booked_slots, true) : [];
                                if (is_array($slots) && count($slots)) {
                                    $slotLabels = collect($slots)->map(function($s) {
                                        $start = str_pad($s, 2, '0', STR_PAD_LEFT) . ':00';
                                        $end = str_pad(($s+1)%24, 2, '0', STR_PAD_LEFT) . ':00';
                                        return $start . '-' . $end;
                                    });
                                    echo implode(', ', $slotLabels->toArray());
                                } else {
                                    echo '-';
                                }
                            @endphp
                        </td>
                        <td style="padding:8px;">{{ $booking->vehicle_type }}</td>
                        <td style="padding:8px;">{{ $booking->driver_name }}</td>
                        <td style="padding:8px;">
                            <button type="button" onclick="showEditPopup({{ $booking->booking_id }})" style="padding:4px 12px;">Edit</button>
                        </td>
                    </tr>
                    <!-- Edit Popup Modal -->
                    <div id="edit-modal-{{ $booking->booking_id }}" class="edit-modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.25);z-index:1000;align-items:center;justify-content:center;">
                        <div style="background:#fff;padding:2rem 2.5rem;border-radius:8px;max-width:600px;width:95%;position:relative;">
                            <button onclick="hideEditPopup({{ $booking->booking_id }})" style="position:absolute;top:10px;right:10px;background:none;border:none;font-size:1.5rem;">&times;</button>
                            <h3 style="margin-bottom:1.2rem;text-align:center;">Edit Booking #{{ $booking->booking_id }}</h3>
                            <form method="POST" action="/admin/bookings/{{ $booking->booking_id }}/edit" style="display:flex;flex-direction:column;gap:1.2rem;">
                                @csrf
                                <label for="driver_name">Driver Name</label>
                                <input type="text" id="driver_name" name="driver_name" value="{{ $booking->driver_name }}" placeholder="Driver Name" required>
                                <label for="driver_phone">Driver Phone</label>
                                <input type="text" id="driver_phone" name="driver_phone" value="{{ $booking->driver_phone }}" placeholder="Driver Phone" required>
                                <label for="owner_name">Owner Name</label>
                                <input type="text" id="owner_name" name="owner_name" value="{{ $booking->owner_name }}" placeholder="Owner Name" required>
                                <label for="owner_phone">Owner Phone</label>
                                <input type="text" id="owner_phone" name="owner_phone" value="{{ $booking->owner_phone }}" placeholder="Owner Phone" required>
                                <label for="start_time">Booking Date</label>
                                <input type="text" id="start_time" name="booking_date" value="{{ $booking->booking_date }}" placeholder="Booking Date" required>
                                <label for="end_time">Booked Slots</label>
                                <input type="text" id="end_time" name="booked_slots" value="@php $slots = isset($booking->booked_slots) ? json_decode($booking->booked_slots, true) : []; if(is_array($slots)&&count($slots)){ $slotLabels = collect($slots)->map(function($s){ $start = str_pad($s,2,'0',STR_PAD_LEFT).':00'; $end = str_pad(($s+1)%24,2,'0',STR_PAD_LEFT).':00'; return $start.'-'.$end; }); echo implode(', ',$slotLabels->toArray()); } @endphp" placeholder="Booked Slots" readonly>
                                <label for="vehicle_type">Vehicle Type</label>
                                <select id="vehicle_type" name="vehicle_type" required>
                                    <option value="car" {{ $booking->vehicle_type == 'car' ? 'selected' : '' }}>Car</option>
                                    <option value="bike" {{ $booking->vehicle_type == 'bike' ? 'selected' : '' }}>Bike</option>
                                    <option value="bycle" {{ $booking->vehicle_type == 'bycle' ? 'selected' : '' }}>Bicycle</option>
                                </select>
                                <label for="vehicle_details">Vehicle Details</label>
                                <input type="text" id="vehicle_details" name="vehicle_details" value="{{ $booking->vehicle_details }}" placeholder="Vehicle Details">
                                <label for="tranx_id">Tranx ID</label>
                                <input type="text" id="tranx_id" name="tranx_id" value="{{ $booking->tranx_id }}" placeholder="Tranx ID">
                                <div style="display:flex;gap:1.5rem;justify-content:center;margin-top:0.5rem;">
                                    <button type="submit" style="padding:8px 24px;background:#444;color:#fff;border:none;border-radius:4px;">Save</button>
                                    <button type="button" onclick="hideEditPopup({{ $booking->booking_id }})" style="padding:8px 24px;background:#eee;color:#222;border:none;border-radius:4px;">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="10" style="text-align:center;">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
<script>
function showEditPopup(id) {
    document.getElementById('edit-modal-' + id).style.display = 'flex';
}
function hideEditPopup(id) {
    document.getElementById('edit-modal-' + id).style.display = 'none';
}
</script>
@endsection
