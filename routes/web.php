<?php

use App\Http\Controllers\LoginOauth;
use App\Http\Controllers\RegisterOauth;
use App\Models\TokenUser;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    return view('register');
})->name('register');


Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

// Google login
Route::get('/login/google', [LoginOauth::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/callback', [LoginOauth::class, 'handleGoogleCallback']);


// Google register
Route::get('/register/google', [RegisterOauth::class, 'redirectToGoogle'])->name('register.google');
Route::get('register/callback', [RegisterOauth::class, 'handleGoogleCallback']);
Route::get('/privacy-confirm', function () {
    return view('auth.privacy_confirm');
});


// // Logout
// Route::post('/logout', function () {
//     TokenUser::where('user_id', auth()->id())->delete();

//     // Logout Laravel
//     Auth::logout();
//     request()->session()->invalidate();
//     request()->session()->regenerateToken();

//     return redirect('/');
// })->name('logout');

