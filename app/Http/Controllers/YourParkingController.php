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

        // Support search from search_field/search_value (from the form)
        $searchError = null;
        if ($request->filled('search_field') && $request->filled('search_value')) {
            $field = $request->search_field;
            $value = $request->search_value;
            if (in_array($field, ['garage_id', 'area', 'division', 'nid'])) {
                if ($field === 'garage_id') {
                    if (is_numeric($value)) {
                        $query->where('garage_id', (int)$value);
                    } else {
                        $searchError = 'Garage ID must be a number.';
                    }
                } else if ($field === 'division') {
                    $query->whereRaw('LOWER(division) LIKE ?', ['%' . strtolower($value) . '%']);
                } else if ($field === 'area') {
                    $query->whereRaw('LOWER(area) LIKE ?', ['%' . strtolower($value) . '%']);
                } else if ($field === 'nid') {
                    $query->where('nid', 'like', '%' . $value . '%');
                }
            } else {
                $searchError = 'Invalid search field.';
            }
        }

        // Remove old direct query param filters to avoid conflicts
        $garages = $query->get();
        return view('your_parking', compact('garages', 'searchError'));
    }
}
