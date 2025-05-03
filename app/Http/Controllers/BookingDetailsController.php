<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingDetailsController extends Controller
{
    public function show($garage_id)
    {
        $garage = DB::table('parking_details')->where('garage_id', $garage_id)->first();
        if (!$garage) {
            abort(404);
        }
        // Optionally fetch owner info if needed
        $owner = DB::table('users')->where('id', $garage->usr_id)->first();
        return view('booking_details', compact('garage', 'owner'));
    }

    public function store(Request $request, $garage_id)
    {
        $userId = session('user_id');
        $garage = DB::table('parking_details')->where('garage_id', $garage_id)->first();
        if (!$garage) abort(404);
        $owner = DB::table('users')->where('id', $garage->usr_id)->first();

        $start = strtotime($request->input('start_time'));
        $end = strtotime($request->input('end_time'));
        $hours = max(1, ceil(($end - $start) / 3600));
        $total_rent = $garage->rent * $hours;

        $booking_id = DB::table('bookings')->insertGetId([
            'garage_id' => $garage_id,
            'user_id' => $userId,
            'driver_name' => $request->input('driver_name'),
            'driver_phone' => $request->input('driver_phone'),
            'owner_name' => session('user_name'),
            'owner_phone' => session('user_phone'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'vehicle_type' => $request->input('vehicle_type'),
            'vehicle_details' => $request->input('vehicle_details'),
            'tranx_id' => null,
        ], 'booking_id');
        return redirect()->route('order-confirmation', ['booking_id' => $booking_id]);
    }

    public function confirmation($booking_id)
    {
        $booking = DB::table('bookings')->where('booking_id', $booking_id)->first();
        $garage = $booking ? DB::table('parking_details')->where('garage_id', $booking->garage_id)->first() : null;
        return view('order_confirmation', compact('booking', 'garage'));
    }

    public function previous() {
        $userId = session('user_id');
        $bookings = DB::table('bookings')
            ->where('user_id', $userId)
            ->join('parking_details', 'bookings.garage_id', '=', 'parking_details.garage_id')
            ->select('bookings.*', 'parking_details.area', 'parking_details.division', 'parking_details.rent', 'parking_details.parking_type', 'parking_details.location')
            ->orderByDesc('bookings.created_at')
            ->get();
        return view('previous_parking', compact('bookings'));
    }
}
