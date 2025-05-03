@extends('layouts.app')
@section('title', 'Previous Parkings')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:2.5rem 2.5rem 2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:900px;width:100%;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:2rem;">Your Previous Parkings</h2>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f3f3f3;">
                    <th style="padding:8px;">#</th>
                    <th style="padding:8px;">Area</th>
                    <th style="padding:8px;">Division</th>
                    <th style="padding:8px;">Location</th>
                    <th style="padding:8px;">Type</th>
                    <th style="padding:8px;">Rent/hr</th>
                    <th style="padding:8px;">Start</th>
                    <th style="padding:8px;">End</th>
                    <th style="padding:8px;">Vehicle</th>
                    <th style="padding:8px;">Driver</th>
                    <th style="padding:8px;">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $i => $booking)
                    @php
                        $start = strtotime($booking->start_time);
                        $end = strtotime($booking->end_time);
                        $hours = max(1, ceil(($end - $start) / 3600));
                        $total_rent = ($booking->rent ?? 0) * $hours;
                    @endphp
                    <tr>
                        <td style="padding:8px;">{{ $i+1 }}</td>
                        <td style="padding:8px;">{{ $booking->area }}</td>
                        <td style="padding:8px;">{{ $booking->division }}</td>
                        <td style="padding:8px;">{{ $booking->location }}</td>
                        <td style="padding:8px;">{{ ucfirst($booking->parking_type) }}</td>
                        <td style="padding:8px;">{{ $booking->rent }}</td>
                        <td style="padding:8px;">{{ $booking->start_time }}</td>
                        <td style="padding:8px;">{{ $booking->end_time }}</td>
                        <td style="padding:8px;">{{ $booking->vehicle_type }}</td>
                        <td style="padding:8px;">{{ $booking->driver_name }}</td>
                        <td style="padding:8px;">{{ $total_rent }}</td>
                    </tr>
                @empty
                    <tr><td colspan="11" style="text-align:center;">No previous bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
