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

Route::get('/', function () {
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

Route::get('/register-parking', [RegisterParkingController::class, 'showForm']);
Route::post('/register-parking', [RegisterParkingController::class, 'register'])->name('register-parking');

Route::get('/your-parking', [YourParkingController::class, 'index'])->name('your-parking');

Route::get('/edit-parking/{garage_id}', [EditParkingController::class, 'edit'])->name('edit-parking');
Route::post('/edit-parking/{garage_id}', [EditParkingController::class, 'update'])->name('update-parking');

Route::get('/booking-details/{garage_id}', [BookingDetailsController::class, 'show'])->name('booking-details');
Route::post('/booking-details/{garage_id}', [BookingDetailsController::class, 'store'])->name('booking-details.store');
Route::get('/order-confirmation/{booking_id}', [BookingDetailsController::class, 'confirmation'])->name('order-confirmation');

Route::get('/previous-parking', [BookingDetailsController::class, 'previous'])->name('previous-parking');
