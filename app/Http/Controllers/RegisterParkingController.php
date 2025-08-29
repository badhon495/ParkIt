<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Services\CloudinaryService;

class RegisterParkingController extends Controller
{
    public function showForm()
    {
        $userType = session('user_type');
        if ($userType !== 'owner') {
            return redirect('/signin');
        }
        $user = [
            'name' => session('user_name'),
            'phone' => session('user_phone'),
            'email' => session('user_email'),
        ];
        return view('register_parking', compact('user'));
    }

    public function register(Request $request)
    {
        $userType = session('user_type');
        if ($userType !== 'owner') {
            return redirect('/signin');
        }

        $validated = $request->validate([
            'owner_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'division' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'address' => 'required|string',
            'cc_camera' => 'required|in:0,1',
            'guard' => 'required|in:0,1',
            'indoor' => 'required|in:indoor,outdoor',
            'slots' => 'required|array',
            'place_type' => 'required|string',
            'nid' => 'required|string',
            'customer_id' => 'required|string',
            'passport' => 'nullable|string',
            'nid_photo' => 'required|image',
            'bill_photo' => 'required|image',
            'passport_photo' => 'nullable|image',
            'garage_photos.*' => 'nullable|image',
            'payment_method' => 'required|string',
            'bank_details' => 'nullable|string',
            'alternate_person_name' => 'nullable|string',
            'alternate_person_phone' => 'nullable|string',
            'rent' => 'required|numeric|min:0',
        ]);

        // Debug: Show all request data and stop execution
        // Remove or comment out after debugging
        Log::info('Register Parking Request:', $request->all());
        // dd($request->all());

        $cloudinaryService = new CloudinaryService();

        // Handle file uploads to Cloudinary
        $nid_photo_result = $cloudinaryService->uploadFile($request->file('nid_photo'), 'parkit/nid_photos');
        $bill_photo_result = $cloudinaryService->uploadFile($request->file('bill_photo'), 'parkit/bill_photos');
        
        $passport_photo_result = null;
        if ($request->file('passport_photo')) {
            $passport_photo_result = $cloudinaryService->uploadFile($request->file('passport_photo'), 'parkit/passport_photos');
        }

        // Check for upload errors
        if (!$nid_photo_result['success'] || !$bill_photo_result['success']) {
            return redirect()->back()->with('error', 'Failed to upload required documents. Please try again.');
        }

        // Handle garage photo uploads
        $garagePhotoPaths = [];
        if ($request->hasFile('garage_photos')) {
            foreach ($request->file('garage_photos') as $photo) {
                if ($photo && $photo->isValid()) {
                    $result = $cloudinaryService->uploadFile($photo, 'parkit/garage_photos');
                    if ($result['success']) {
                        $garagePhotoPaths[] = $result['url'];
                    }
                }
            }
        }

        // Insert into parking_details table
        DB::table('parking_details')->insert([
            'usr_id' => session('user_id'), // Ensure the garage is linked to the current user
            'images' => $garagePhotoPaths ? json_encode($garagePhotoPaths) : null,
            'rent' => $request->input('rent'),
            'parking_type' => $request->input('place_type'),
            'area' => $request->input('area'),
            'division' => $request->input('division'),
            'location' => $request->input('address'),
            'camera' => $request->input('cc_camera'),
            'guard' => $request->input('guard'),
            'slots' => json_encode($request->input('slots', [])),
            'nid' => $request->input('nid'),
            'utility_bill' => $request->input('customer_id'),
            'passport' => $request->input('passport'),
            'alt_name' => $request->input('alternate_person_name'),
            'alt_phone' => $request->input('alternate_person_phone'),
            'indoor' => $request->input('indoor'),
            'payment_method' => $request->input('payment_method'),
            'bank_details' => $request->input('bank_details'),
            'nid_photo_url' => $nid_photo_result['url'],
            'bill_photo_url' => $bill_photo_result['url'],
            'passport_photo_url' => $passport_photo_result ? $passport_photo_result['url'] : null,
        ]);

        return redirect('/register-parking')->with('success', 'Parking registered successfully!');
    }
}
