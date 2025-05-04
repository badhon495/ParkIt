<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingDetailsController extends Controller
{
    public function show($garage_id)
    {
        if (!session('user_id')) {
            return redirect('/signin')->with('error', 'You must be logged in to view booking details.');
        }
        $garage = DB::table('parking_details')->where('garage_id', $garage_id)->first();
        if (!$garage) {
            abort(404);
        }
        $owner = DB::table('users')->where('id', $garage->usr_id)->first();
        // Get all booked slots for this garage
        $bookedSlots = DB::table('bookings')
            ->where('garage_id', $garage_id)
            ->select('start_time', 'end_time', 'booking_date')
            ->get();
        return view('booking_details', compact('garage', 'owner', 'bookedSlots'));
    }

    public function store(Request $request, $garage_id)
    {
        $userId = session('user_id');
        $garage = DB::table('parking_details')->where('garage_id', $garage_id)->first();
        if (!$garage) abort(404);

        // Check for overlapping bookings
        $booking_date = $request->input('booking_date');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $overlap = DB::table('bookings')
            ->where('garage_id', $garage_id)
            ->where('booking_date', $booking_date)
            ->where(function($q) use ($start_time, $end_time) {
                $q->where(function($q2) use ($start_time, $end_time) {
                    $q2->where('start_time', '<', $end_time)
                        ->where('end_time', '>', $start_time);
                });
            })
            ->exists();
        if ($overlap) {
            return redirect()->back()->withInput()->withErrors(['booking_date' => 'This garage is already booked for the selected date and time slot. Please choose a different time.']);
        }

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
            'booking_date' => $request->input('booking_date'),
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

    public function adminBookings(Request $request) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $query = DB::table('bookings')
            ->join('parking_details', 'bookings.garage_id', '=', 'parking_details.garage_id')
            ->select('bookings.*', 'parking_details.area', 'parking_details.division', 'parking_details.rent', 'parking_details.parking_type', 'parking_details.location', 'parking_details.images');
        if ($request->filled('search_id')) {
            $query->where('bookings.booking_id', $request->search_id);
        }
        $bookings = $query->orderByDesc('bookings.created_at')->get();
        return view('admin_bookings', compact('bookings'));
    }

    public function adminEditBooking(Request $request, $booking_id) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $fields = [
            'driver_name', 'driver_phone', 'owner_name', 'owner_phone', 'start_time', 'end_time', 'vehicle_type', 'vehicle_details', 'tranx_id'
        ];
        $data = $request->only($fields);
        DB::table('bookings')->where('booking_id', $booking_id)->update($data);
        return redirect()->back()->with('success', 'Booking updated successfully!');
    }

    public function adminUsers(Request $request) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $query = DB::table('users');
        if ($request->filled('search_id')) {
            $query->where('id', $request->search_id);
        }
        $users = $query->orderByDesc('id')->get();
        return view('admin_users', compact('users'));
    }

    // Admin: Parking List
    public function adminParkingList(Request $request) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $query = DB::table('parking_details')
            ->join('users', 'parking_details.usr_id', '=', 'users.id')
            ->select('parking_details.*', 'users.name as owner_name', 'users.phone as owner_phone');
        if ($request->filled('search_field') && $request->filled('search_value')) {
            $field = $request->search_field;
            $value = $request->search_value;
            if (in_array($field, ['garage_id', 'area', 'division', 'nid'])) {
                if ($field === 'garage_id') {
                    $query->where('parking_details.garage_id', $value);
                } else {
                    $query->where('parking_details.' . $field, 'like', '%' . $value . '%');
                }
            }
        }
        $garages = $query->orderByDesc('garage_id')->get();
        return view('admin_parking', compact('garages'));
    }

    // Admin: Edit parking view
    public function adminEditParkingView($garage_id)
    {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $garage = DB::table('parking_details')->where('garage_id', $garage_id)->first();
        if (!$garage) {
            return redirect()->route('admin.parking')->with('error', 'Garage not found.');
        }
        $owner = DB::table('users')->where('id', $garage->usr_id)->first();
        return view('admin_edit_parking', compact('garage', 'owner'));
    }

    // Admin: Update parking
    public function adminEditParkingUpdate(Request $request, $garage_id)
    {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $fields = [
            'area', 'division', 'location', 'camera', 'guard', 'indoor', 'bike_slot', 'car_slot', 'bicycle_slot',
            'start_time', 'end_time', 'nid', 'utility_bill', 'passport', 'alt_name', 'alt_phone', 'payment_method', 'bank_details', 'rent', 'parking_type'
        ];
        $data = $request->only($fields);
        DB::table('parking_details')->where('garage_id', $garage_id)->update($data);
        return redirect()->route('admin.edit-parking', $garage_id)->with('success', 'Garage updated successfully!');
    }

    public function ownerDashboard()
    {
        $userId = session('user_id');
        if (!$userId || session('user_type') !== 'owner') {
            return redirect('/signin');
        }
        // Get all garages owned by this user
        $garages = DB::table('parking_details')->where('usr_id', $userId)->get();
        $garageIds = $garages->pluck('garage_id')->toArray();
        // Get all bookings for these garages
        $bookings = DB::table('bookings')
            ->whereIn('bookings.garage_id', $garageIds)
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('parking_details', 'bookings.garage_id', '=', 'parking_details.garage_id')
            ->select(
                'bookings.*',
                'users.name as user_name',
                'users.phone as user_phone',
                'parking_details.rent'
            )
            ->orderByDesc('bookings.created_at')
            ->get();
        // Calculate total earnings
        $totalEarnings = 0;
        foreach ($bookings as $booking) {
            $start = strtotime($booking->start_time);
            $end = strtotime($booking->end_time);
            $hours = max(1, ceil(($end - $start) / 3600));
            $totalEarnings += $booking->rent * $hours;
        }
        return view('owner_dashboard', compact('garages', 'bookings', 'totalEarnings'));
    }
}
