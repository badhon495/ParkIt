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
        // Fetch garages listed by this user
        $garages = DB::table('parking_details')->where('usr_id', $userId)->get();
        return view('your_parking', compact('garages'));
    }
}
