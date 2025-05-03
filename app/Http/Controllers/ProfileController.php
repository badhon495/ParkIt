<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile');
    }

    public function edit()
    {
        return view('profile_edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);
        $userId = Session::get('user_id');
        if (!$userId) {
            return redirect('/signin');
        }
        // Update user in DB
        $updateData = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ];
        // Handle password change if requested
        if ($request->filled('current_password') || $request->filled('new_password') || $request->filled('new_password_confirmation')) {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|string|min:6|confirmed',
            ]);
            $user = DB::table('users')->where('id', $userId)->first();
            if (!$user || !Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }
            $updateData['password'] = Hash::make($request->input('new_password'));
        }
        DB::table('users')->where('id', $userId)->update($updateData);
        // Update session
        Session::put('user_name', $request->input('name'));
        Session::put('user_phone', $request->input('phone'));
        Session::put('user_email', $request->input('email'));
        return redirect('/profile/edit')->with('success', 'Profile updated successfully!');
    }

    // User: Delete own account
    public function delete(Request $request)
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return redirect('/signin');
        }
        DB::table('users')->where('id', $userId)->delete();
        Session::flush();
        return redirect('/')->with('success', 'Your account has been deleted.');
    }

    // Admin: Edit user form
    public function adminEdit($id) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) abort(404);
        return view('profile_edit', ['admin_user' => $user]);
    }

    // Admin: Update user
    public function adminUpdate(Request $request, $id) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);
        $updateData = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'type' => $request->input('type'),
        ];
        if ($request->filled('new_password')) {
            $request->validate([
                'new_password' => 'required|string|min:6|confirmed',
            ]);
            $updateData['password'] = Hash::make($request->input('new_password'));
        }
        DB::table('users')->where('id', $id)->update($updateData);
        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    // Admin: Delete user
    public function adminDelete(Request $request, $id) {
        if (session('user_type') !== 'admin') abort(403, 'Unauthorized');
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }
}