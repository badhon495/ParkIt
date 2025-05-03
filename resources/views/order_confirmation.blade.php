@extends('layouts.app')
@section('title', 'Order Confirmation')
@section('content')
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;">
    <div style="display:flex;align-items:center;justify-content:center;width:100%;max-width:900px;">
        <div style="flex:1;text-align:center;">
            <h1 style="font-size:2.2rem;font-weight:700;margin-bottom:1.5rem;">YaaY..<br>Your Order has<br>been Confirmed</h1>
        </div>
        <div style="flex:1;max-width:350px;background:#fff;padding:2rem 2.5rem 2rem 2.5rem;border-radius:0.5rem;box-shadow:0 1px 8px rgba(0,0,0,0.10);">
            <h2 style="text-align:center;font-size:1.3rem;font-weight:600;margin-bottom:1.2rem;">Order Details</h2>
            <input type="text" value="{{ $garage->area ?? '' }}" placeholder="Area" readonly style="width:100%;margin-bottom:1rem;">
            <input type="text" value="{{ $booking->start_time }} - {{ $booking->end_time }}" placeholder="Time" readonly style="width:100%;margin-bottom:1rem;">
            <input type="text" value="{{ $garage->rent ?? '' }}" placeholder="Per Hour Rent" readonly style="width:100%;margin-bottom:1rem;">
            @php
                $start = strtotime($booking->start_time);
                $end = strtotime($booking->end_time);
                $hours = max(1, ceil(($end - $start) / 3600));
                $total_rent = ($garage->rent ?? 0) * $hours;
            @endphp
            <input type="text" value="{{ $total_rent }}" placeholder="Total Rent" readonly style="width:100%;margin-bottom:1.5rem;">
            <form method="get" action="/previous-parking" style="width:100%;">
                <button class="search-button" style="width:100%;font-size:1.1rem;padding:0.7rem 0;">Done</button>
            </form>
            <div style="text-align:center;margin-top:1.5rem;font-size:0.95rem;color:#888;">
                Your parking has been booked for 10 Minutes.<br>
                Please pay to confirm your order
            </div>
        </div>
    </div>
</main>
@endsection
