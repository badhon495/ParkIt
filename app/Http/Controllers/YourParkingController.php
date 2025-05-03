<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YourParkingController extends Controller
{
    public function index(Request $request)
    {
        // Get current user ID from session (adjust as needed for your auth system)
        $userId = session('user_id');
        if (!$userId) {
            return redirect('/signin');
        }

        $query = DB::table('parking_details')->where('usr_id', $userId);
        if ($request->filled('garage_id')) {
            $query->where('garage_id', $request->garage_id);
        }
        if ($request->filled('area')) {
            $query->where('area', 'like', '%' . $request->area . '%');
        }
        if ($request->filled('division')) {
            $query->where('division', 'like', '%' . $request->division . '%');
        }
        if ($request->filled('nid')) {
            $query->where('nid', 'like', '%' . $request->nid . '%');
        }

        $garages = $query->get();
        return view('your_parking', compact('garages'));
    }
}
