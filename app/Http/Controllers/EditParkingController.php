<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditParkingController extends Controller
{
    public function edit($garage_id)
    {
        $userId = session('user_id');
        $garage = DB::table('parking_details')->where('garage_id', $garage_id)->where('usr_id', $userId)->first();
        if (!$garage) {
            return redirect('/your-parking')->with('error', 'Garage not found or access denied.');
        }
        $user = [
            'name' => session('user_name'),
            'phone' => session('user_phone'),
            'email' => session('user_email'),
        ];
        return view('edit_parking', compact('garage', 'user'));
    }

    public function update(Request $request, $garage_id)
    {
        $userId = session('user_id');
        $garage = DB::table('parking_details')->where('garage_id', $garage_id)->where('usr_id', $userId)->first();
        if (!$garage) {
            return redirect('/your-parking')->with('error', 'Garage not found or access denied.');
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
            'payment_method' => 'required|string',
            'bank_details' => 'nullable|string',
            'alternate_person_name' => 'nullable|string',
            'alternate_person_phone' => 'nullable|string',
            'rent' => 'required|numeric|min:0',
        ]);

        // Handle new garage photo uploads
        $garagePhotoPaths = $garage->images ? json_decode($garage->images, true) : [];
        if ($request->hasFile('garage_photos')) {
            foreach ($request->file('garage_photos') as $photo) {
                if ($photo && $photo->isValid()) {
                    $garagePhotoPaths[] = $photo->store('uploads/garage_photos', 'public');
                }
            }
        }

        DB::table('parking_details')->where('garage_id', $garage_id)->update([
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
            'payment_method' => $request->input('payment_method'),
            'bank_details' => $request->input('bank_details'),
            'indoor' => $request->input('indoor'),
            'images' => $garagePhotoPaths ? json_encode($garagePhotoPaths) : null,
        ]);

        return redirect('/your-parking')->with('success', 'Garage details updated successfully!');
    }

    public function removeImages(Request $request, $garage_id)
    {
        $userId = session('user_id');
        $garage = DB::table('parking_details')->where('garage_id', $garage_id)->where('usr_id', $userId)->first();
        if (!$garage) {
            return redirect()->back()->with('error', 'Garage not found or access denied.');
        }
        $selectedImages = $request->input('images', []);
        if (empty($selectedImages)) {
            return redirect()->back()->with('error', 'No images selected.');
        }
        $images = $garage->images ? json_decode($garage->images, true) : [];
        $remainingImages = array_values(array_diff($images, $selectedImages));
        // Optionally delete files from storage
        foreach ($selectedImages as $img) {
            $imgPath = storage_path('app/public/' . $img);
            if (file_exists($imgPath)) {
                @unlink($imgPath);
            }
        }
        DB::table('parking_details')->where('garage_id', $garage_id)->update([
            'images' => json_encode($remainingImages)
        ]);
        return redirect()->back()->with('success', 'Selected images deleted successfully.');
    }

    public function destroy($garage_id)
    {
        $userId = session('user_id');
        $garage = DB::table('parking_details')->where('garage_id', $garage_id)->where('usr_id', $userId)->first();
        if (!$garage) {
            return redirect('/your-parking')->with('error', 'Garage not found or access denied.');
        }
        // Delete all bookings for this garage
        DB::table('bookings')->where('garage_id', $garage_id)->delete();
        // Delete the garage itself
        DB::table('parking_details')->where('garage_id', $garage_id)->delete();
        return redirect('/your-parking')->with('success', 'Garage and all its bookings deleted successfully!');
    }
}
