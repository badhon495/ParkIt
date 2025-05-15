@extends('layouts.app')
@section('title', 'Previous Parkings')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:5rem 5rem 5rem 5rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);max-width:900px;width:100%;overflow-x:auto;">
        <h2 style="text-align:center;font-size:2rem;font-weight:700;color:#444;margin-bottom:2rem;">Your Previous Parkings</h2>
        <table style="width:100%;border-collapse:collapse;table-layout:fixed;word-break:break-word;">
            <thead>
                <tr style="background:#f3f3f3;">
                    <th style="padding:8px;">#</th>
                    <th style="padding:8px;">Area</th>
                    <th style="padding:8px;">Division</th>
                    <th style="padding:8px;">Location</th>
                    <th style="padding:8px;">Type</th>
                    <th style="padding:8px;">Rent/hr</th>
                    <th style="padding:8px;">Slots</th>
                    <th style="padding:8px;">Vehicle</th>
                    <th style="padding:8px;">Driver</th>
                    <th style="padding:8px;">Total Amount</th>
                    <th style="padding:8px;">Owner Email</th>
                    <th style="padding:8px;">Owner Phone</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $i => $booking)
                    @php
                        $slots = json_decode($booking->booked_slots ?? '[]', true);
                        $slotLabels = collect($slots)->map(fn($s) => sprintf('%02d:00-%02d:00', $s, ($s+1)%24));
                        $total_rent = ($booking->rent ?? 0) * (is_array($slots) ? count($slots) : 0);
                    @endphp
                    <tr>
                        <td style="padding:8px;word-break:break-word;max-width:40px;">{{ $i+1 }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:80px;">{{ $booking->area }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:80px;">{{ $booking->division }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:120px;">{{ $booking->location }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:100px;">{{ ucfirst($booking->parking_type) }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:60px;">{{ $booking->rent }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:120px;">{{ $slotLabels->implode(', ') }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:80px;">{{ $booking->vehicle_type }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:80px;">{{ $booking->driver_name }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:80px;">{{ $total_rent }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:140px;white-space:pre-line;">{{ wordwrap($booking->owner_email, 18, "\n", true) }}</td>
                        <td style="padding:8px;word-break:break-word;max-width:120px;">{{ $booking->owner_phone }}</td>
                    </tr>
                @empty
                    <tr><td colspan="12" style="text-align:center;">No previous bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
