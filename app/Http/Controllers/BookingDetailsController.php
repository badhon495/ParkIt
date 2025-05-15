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
            ->select('booked_slots', 'booking_date')
            ->get();
        return view('booking_details', compact('garage', 'owner', 'bookedSlots'));
    }

    public function store(Request $request, $garage_id)
    {
        $userId = session('user_id');
        $garage = DB::table('parking_details')->where('garage_id', $garage_id)->first();
        if (!$garage) abort(404);

        $booking_date = $request->input('booking_date');
        $selectedSlots = $request->input('booking_slots', []);
        // Check for overlapping slots on the same date
        $existingBookings = DB::table('bookings')
            ->where('garage_id', $garage_id)
            ->where('booking_date', $booking_date)
            ->pluck('booked_slots');
        $alreadyBooked = [];
        foreach ($existingBookings as $json) {
            $arr = json_decode($json, true);
            if (is_array($arr)) {
                $alreadyBooked = array_merge($alreadyBooked, $arr);
            }
        }
        // Only allow booking for slots that are not already booked
        $conflictSlots = array_intersect($selectedSlots, $alreadyBooked);
        if (count($conflictSlots) > 0) {
            return redirect()->back()->withInput()->withErrors(['booking_slots' => 'One or more selected slots are already booked for this date. Please choose different slots.']);
        }

        $total_rent = $garage->rent * count($selectedSlots);
        $trxn = $request->input('trxn');

        $booking_id = DB::table('bookings')->insertGetId([
            'garage_id' => $garage_id,
            'user_id' => $userId,
            'driver_name' => $request->input('driver_name'),
            'driver_phone' => $request->input('driver_phone'),
            'owner_name' => session('user_name'),
            'owner_phone' => session('user_phone'),
            'booked_slots' => json_encode($selectedSlots),
            'vehicle_type' => $request->input('vehicle_type'),
            'vehicle_details' => $request->input('vehicle_details'),
            'total_cost' => $total_rent,
            'trxn' => $trxn ?? '',
            'booking_date' => $request->input('booking_date'),
        ], 'booking_id');
        return redirect()->route('order-confirmation', ['booking_id' => $booking_id]);
    }

    public function confirmation(Request $request, $booking_id)
    {
        if ($request->isMethod('post')) {
            $trxn = $request->input('trxn');
            DB::table('bookings')->where('booking_id', $booking_id)->update(['trxn' => $trxn]);
            return redirect()->route('previous-parking')->with('success', 'Transaction ID saved and order confirmed!');
        }
        $booking = DB::table('bookings')->where('booking_id', $booking_id)->first();
        $garage = $booking ? DB::table('parking_details')->where('garage_id', $booking->garage_id)->first() : null;
        return view('order_confirmation', compact('booking', 'garage'));
    }

    public function previous() {
        $userId = session('user_id');
        $bookings = DB::table('bookings')
            ->where('user_id', $userId)
            ->join('parking_details', 'bookings.garage_id', '=', 'parking_details.garage_id')
            ->join('users', 'parking_details.usr_id', '=', 'users.id')
            ->select(
                'bookings.*',
                'parking_details.area',
                'parking_details.division',
                'parking_details.rent',
                'parking_details.parking_type',
                'parking_details.location',
                'users.email as owner_email',
                'users.phone as owner_phone'
            )
            ->orderByDesc('bookings.created_at')
            ->get();
        return view('previous_parking', compact('bookings'));
    }

    public function adminBookings(Request $request) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $query = DB::table('bookings')
            ->join('parking_details', 'bookings.garage_id', '=', 'parking_details.garage_id')
            ->select('bookings.*', 'parking_details.area', 'parking_details.division', 'parking_details.rent', 'parking_details.parking_type', 'parking_details.location', 'parking_details.images');
        $error = null;
        if ($request->filled('search_id')) {
            try {
                if (!is_numeric($request->search_id)) throw new \Exception('Booking ID must be a number.');
                $query->where('bookings.booking_id', $request->search_id);
            } catch (\Throwable $e) {
                $error = 'Wrong input: ' . $e->getMessage();
            }
        }
        $bookings = $query->orderByDesc('bookings.created_at')->get();
        return view('admin_bookings', compact('bookings', 'error'));
    }

    public function adminEditBooking(Request $request, $booking_id) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $fields = [
            'driver_name', 'driver_phone', 'owner_name', 'owner_phone', 'vehicle_type', 'vehicle_details', 'trxn'
        ];
        $data = $request->only($fields);
        DB::table('bookings')->where('booking_id', $booking_id)->update($data);
        return redirect()->back()->with('success', 'Booking updated successfully!');
    }

    public function adminDeleteBooking($booking_id) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        DB::table('bookings')->where('booking_id', $booking_id)->delete();
        return redirect()->back()->with('success', 'Booking deleted successfully!');
    }

    public function adminUsers(Request $request) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $query = DB::table('users');
        $error = null;
        if ($request->filled('search_id')) {
            try {
                if (!is_numeric($request->search_id)) throw new \Exception('User ID must be a number.');
                $query->where('id', $request->search_id);
            } catch (\Throwable $e) {
                $error = 'Wrong input: ' . $e->getMessage();
            }
        }
        $users = $query->orderByDesc('id')->get();
        return view('admin_users', compact('users', 'error'));
    }

    // Admin: Parking List
    public function adminParkingList(Request $request) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $query = DB::table('parking_details')
            ->join('users', 'parking_details.usr_id', '=', 'users.id')
            ->select('parking_details.*', 'users.name as owner_name', 'users.phone as owner_phone');
        $error = null;
        if ($request->filled('search_field') && $request->filled('search_value')) {
            $field = $request->search_field;
            $value = $request->search_value;
            try {
                if (in_array($field, ['garage_id', 'area', 'division', 'nid'])) {
                    if ($field === 'garage_id') {
                        if (!is_numeric($value)) throw new \Exception('Garage ID must be a number.');
                        $query->where('parking_details.garage_id', $value);
                    } else {
                        $query->where('parking_details.' . $field, 'like', '%' . $value . '%');
                    }
                }
            } catch (\Throwable $e) {
                $error = 'Wrong input: ' . $e->getMessage();
            }
        }
        $garages = $query->orderByDesc('garage_id')->get();
        return view('admin_parking', compact('garages', 'error'));
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
        // Only validate fields that are present in the request
        $rules = [
            'area' => 'sometimes|string|max:100',
            'division' => 'sometimes|string|max:100',
            'address' => 'sometimes|string',
            'cc_camera' => 'sometimes|in:0,1',
            'guard' => 'sometimes|in:0,1',
            'indoor' => 'sometimes|in:indoor,outdoor',
            'slots' => 'sometimes|array',
            'nid' => 'sometimes|string',
            'customer_id' => 'sometimes|string',
            'passport' => 'nullable|string',
            'alternate_person_name' => 'nullable|string',
            'alternate_person_phone' => 'nullable|string',
            'payment_method' => 'sometimes|string',
            'bank_details' => 'nullable|string',
            'rent' => 'sometimes|numeric|min:0',
            'place_type' => 'sometimes|string',
        ];
        $validated = $request->validate($rules);
        $data = $request->only(array_keys($rules));
        // Map form fields to DB columns
        $dbData = [];
        if (isset($data['area'])) $dbData['area'] = $data['area'];
        if (isset($data['division'])) $dbData['division'] = $data['division'];
        if (isset($data['address'])) $dbData['location'] = $data['address'];
        if (isset($data['cc_camera'])) $dbData['camera'] = $data['cc_camera'];
        if (isset($data['guard'])) $dbData['guard'] = $data['guard'];
        if (isset($data['indoor'])) $dbData['indoor'] = $data['indoor'];
        if (isset($data['slots'])) $dbData['slots'] = json_encode($data['slots']);
        if (isset($data['nid'])) $dbData['nid'] = $data['nid'];
        if (isset($data['customer_id'])) $dbData['utility_bill'] = $data['customer_id'];
        if (isset($data['passport'])) $dbData['passport'] = $data['passport'];
        if (isset($data['alternate_person_name'])) $dbData['alt_name'] = $data['alternate_person_name'];
        if (isset($data['alternate_person_phone'])) $dbData['alt_phone'] = $data['alternate_person_phone'];
        if (isset($data['payment_method'])) $dbData['payment_method'] = $data['payment_method'];
        if (isset($data['bank_details'])) $dbData['bank_details'] = $data['bank_details'];
        if (isset($data['rent'])) $dbData['rent'] = $data['rent'];
        if (isset($data['place_type'])) $dbData['parking_type'] = $data['place_type'];
        DB::table('parking_details')->where('garage_id', $garage_id)->update($dbData);
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
            $slotsArr = isset($booking->booked_slots) ? json_decode($booking->booked_slots, true) : [];
            $totalEarnings += $booking->rent * count($slotsArr);
        }
        return view('owner_dashboard', compact('garages', 'bookings', 'totalEarnings'));
    }
}
