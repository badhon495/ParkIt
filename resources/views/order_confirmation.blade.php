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
            <label for="area">Area</label>
            <input type="text" id="area" value="{{ $garage->area ?? '' }}" placeholder="Area" readonly style="width:100%;margin-bottom:1rem;">
            <label for="slots">Slots</label>
            <input type="text" id="slots" value="{{ collect(json_decode($booking->booked_slots, true))->map(fn($s) => sprintf('%02d:00-%02d:00', $s, ($s+1)%24))->implode(', ') }}" placeholder="Slots" readonly style="width:100%;margin-bottom:1rem;">
            <label for="rent">Per Hour Rent</label>
            <input type="text" id="rent" value="{{ $garage->rent ?? '' }}" placeholder="Per Hour Rent" readonly style="width:100%;margin-bottom:1rem;">
            @php
                $slots = json_decode($booking->booked_slots, true);
                $total_rent = ($garage->rent ?? 0) * (is_array($slots) ? count($slots) : 0);
            @endphp
            <label for="total_rent">Total Rent</label>
            <input type="text" id="total_rent" value="{{ $total_rent }}" placeholder="Total Rent" readonly style="width:100%;margin-bottom:1.5rem;">
            <label for="trxn">Transaction ID</label>
            <form method="POST" action="{{ url('/order-confirmation/' . $booking->booking_id) }}">
                @csrf
                <input type="text" id="trxn" name="trxn" placeholder="Transaction ID" required style="width:100%;margin-bottom:1.5rem;">
                <button class="search-button" type="submit" style="width:100%;font-size:1.1rem;padding:0.7rem 0;">Confirm & Complete Order</button>
            </form>
            <div style="text-align:center;margin-top:1.5rem;font-size:0.95rem;color:#888;">
                Your parking has been booked for 10 Minutes.<br>
                Please pay to 01533024558 to confirm your order
            </div>
        </div>
    </div>
</main>
@endsection
