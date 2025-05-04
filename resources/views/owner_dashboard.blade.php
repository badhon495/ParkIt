@extends('layouts.app')
@section('title', 'Owner Dashboard | ParkIt')
@section('content')
<div style="min-height:calc(100vh - 120px);display:flex;align-items:center;justify-content:center;">
    <main style="max-width:1100px;margin:2rem auto 3rem auto;padding:2rem;background:#fff;border-radius:10px;box-shadow:0 2px 12px rgba(0,0,0,0.08);width:100%;">
        <h2 style="font-size:2rem;font-weight:700;text-align:center;margin-bottom:2.5rem;">Owner Dashboard</h2>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
            <div style="font-size:1.3rem;font-weight:600;">Total Earnings:</div>
            <div style="font-size:2.2rem;font-weight:700;color:#1a8917;">৳ {{ number_format($totalEarnings, 2) }}</div>
        </div>
        <h3 style="font-size:1.2rem;font-weight:600;margin-bottom:1rem;">All Previous Bookings</h3>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead style="background:#f3f3f3;">
                    <tr>
                        <th style="padding:10px;">Booking ID</th>
                        <th style="padding:10px;">Garage ID</th>
                        <th style="padding:10px;">User Name</th>
                        <th style="padding:10px;">User Phone</th>
                        <th style="padding:10px;">Vehicle Type</th>
                        <th style="padding:10px;">Amount (৳)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr style="border-bottom:1px solid #eee;">
                            <td style="padding:10px;">{{ $booking->booking_id }}</td>
                            <td style="padding:10px;">{{ $booking->garage_id }}</td>
                            <td style="padding:10px;">{{ $booking->user_name }}</td>
                            <td style="padding:10px;">{{ $booking->user_phone }}</td>
                            <td style="padding:10px;">{{ ucfirst($booking->vehicle_type) }}</td>
                            <td style="padding:10px;">
                                @php
                                    $slotsArr = isset($booking->booked_slots) ? json_decode($booking->booked_slots, true) : [];
                                    $amount = $booking->rent * count($slotsArr);
                                @endphp
                                {{ number_format($amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;padding:20px;">No bookings found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
