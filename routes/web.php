<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RegisterParkingController;
use App\Http\Controllers\YourParkingController;
use App\Http\Controllers\EditParkingController;
use App\Http\Controllers\FindParkingController;
use App\Http\Controllers\BookingDetailsController;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    // If logged in, redirect based on user type
    if (session('user_type') === 'admin') {
        return redirect()->route('admin.bookings');
    } elseif (session('user_type') === 'owner') {
        return redirect('owner/dashboard');
    }
    // Otherwise, show homepage for guests
    $featuredGarages = DB::table('parking_details')->orderByDesc('garage_id')->limit(3)->get();
    return view('welcome', compact('featuredGarages'));
});

Route::get('/find-parking', [FindParkingController::class, 'index']);

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/signup', [SignupController::class, 'register']);

Route::get('/signin', [SigninController::class, 'showForm']);
Route::post('/signin', [SigninController::class, 'login']);
Route::get('/logout', [SigninController::class, 'logout']);

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendNewPassword']);

Route::get('/profile', [ProfileController::class, 'show']);
Route::get('/profile/edit', [ProfileController::class, 'edit']);
Route::post('/profile/edit', [ProfileController::class, 'update']);
Route::post('/profile/delete', [ProfileController::class, 'delete'])->name('profile.delete');

Route::get('/register-parking', [RegisterParkingController::class, 'showForm']);
Route::post('/register-parking', [RegisterParkingController::class, 'register'])->name('register-parking');

Route::get('/your-parking', [YourParkingController::class, 'index'])->name('your-parking');

Route::get('/edit-parking/{garage_id}', [EditParkingController::class, 'edit'])->name('edit-parking');
Route::post('/edit-parking/{garage_id}', [EditParkingController::class, 'update'])->name('update-parking');

// Route to handle deleting selected images from a garage
Route::post('/edit-parking/{garage_id}/remove-images', [App\Http\Controllers\EditParkingController::class, 'removeImages'])->name('edit-parking.remove-images');

// Route to handle deleting a garage and its bookings
Route::post('/edit-parking/{garage_id}/delete', [EditParkingController::class, 'destroy'])->name('edit-parking.destroy');

Route::get('/booking-details/{garage_id}', [BookingDetailsController::class, 'show'])->name('booking-details');
Route::post('/booking-details/{garage_id}', [BookingDetailsController::class, 'store'])->name('booking-details.store');
Route::match(['get', 'post'], '/order-confirmation/{booking_id}', [BookingDetailsController::class, 'confirmation'])->name('order-confirmation');

Route::get('/previous-parking', [BookingDetailsController::class, 'previous'])->name('previous-parking');

Route::get('/admin/bookings', [BookingDetailsController::class, 'adminBookings'])->name('admin.bookings');
Route::post('/admin/bookings/{booking_id}/edit', [BookingDetailsController::class, 'adminEditBooking'])->name('admin.bookings.edit');
Route::post('/admin/bookings/{booking_id}/delete', [BookingDetailsController::class, 'adminDeleteBooking'])->name('admin.bookings.delete');
Route::get('/admin/users', [BookingDetailsController::class, 'adminUsers'])->name('admin.users');

// Admin: Edit user
Route::get('/admin/users/{id}/edit', [ProfileController::class, 'adminEdit'])->name('admin.users.edit');
Route::post('/admin/users/{id}/edit', [ProfileController::class, 'adminUpdate'])->name('admin.users.update');
Route::post('/admin/users/{id}/delete', [ProfileController::class, 'adminDelete'])->name('admin.users.delete');

Route::get('/admin/parking', [BookingDetailsController::class, 'adminParkingList'])->name('admin.parking');

// Admin: Edit parking (admin)
Route::get('/admin/edit-parking/{garage_id}', [BookingDetailsController::class, 'adminEditParkingView'])->name('admin.edit-parking');
Route::post('/admin/edit-parking/{garage_id}', [BookingDetailsController::class, 'adminEditParkingUpdate'])->name('admin.edit-parking.update');

Route::get('/owner/dashboard', [BookingDetailsController::class, 'ownerDashboard'])->name('owner.dashboard');

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/auth/google/signup', [GoogleController::class, 'redirectToGoogle'])->name('google.signup');
Route::get('/auth/google/signup/callback', [GoogleController::class, 'handleGoogleSignup']);
