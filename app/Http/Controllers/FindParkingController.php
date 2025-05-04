<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class FindParkingController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = DB::table('parking_details');

        // Division (District)
        if ($request->filled('division')) {
            $query->where('division', $request->division);
        }
        // Area
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }
        // Vehicle type (car, bike, bicycle)
        if ($request->filled('vehicle')) {
            if ($request->vehicle === 'car') {
                $query->where('car_slot', '>', 0);
            } elseif ($request->vehicle === 'bike') {
                $query->where('bike_slot', '>', 0);
            } elseif ($request->vehicle === 'bicycle') {
                $query->where('bicycle_slot', '>', 0);
            }
        }
        // Price range
        if ($request->filled('price_range')) {
            if ($request->price_range == 1) {
                $query->whereBetween('rent', [100, 200]);
            } elseif ($request->price_range == 2) {
                $query->whereBetween('rent', [200, 300]);
            } elseif ($request->price_range == 3) {
                $query->whereBetween('rent', [300, 400]);
            } elseif ($request->price_range == 4) {
                $query->where('rent', '<', 100);
            } elseif ($request->price_range == 5) {
                $query->where('rent', '>', 500);
            }
        }
        // Duration (not implemented in DB, skip or implement if you have logic)
        // Guard
        if ($request->filled('guard')) {
            $query->where('guard', $request->guard);
        }
        // Place type
        if ($request->filled('place_type')) {
            $query->where('parking_type', $request->place_type);
        }
        // CC Camera
        if ($request->filled('cc_camera')) {
            $query->where('camera', $request->cc_camera);
        }

        $garages = $query->get();
        return view('findParking', [
            'garages' => $garages,
            'filters' => $request->all()
        ]);
    }
}
