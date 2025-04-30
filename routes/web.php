<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SigninController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/find-parking', function () {
    return view('findParking');
});

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
