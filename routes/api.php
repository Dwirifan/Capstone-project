<?php

use Illuminate\Http\Request;
use App\Http\Controllers\LoginOauth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\updateProfil;
use App\Http\Controllers\RegisterOauth;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\RegisterContoller;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// login manual
Route::post('user/login', [LoginController::class, 'login']);

// register manual
Route::post('user/register', [RegisterContoller::class, 'register']);

Route::get('/pending/verify/{id}', [RegisterContoller::class, 'verify'])
    ->name('verification.verify')
    ->middleware('signed');

// Google login
Route::get('/login/google', [LoginOauth::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/callback', [LoginOauth::class, 'handleGoogleCallback']);


// Google register
Route::get('/register/google', [RegisterOauth::class, 'redirectToGoogle'])->name('register.google');
Route::get('register/callback', [RegisterOauth::class, 'handleGoogleCallback']);
Route::get('/privacy-confirm', function () {
    return view('auth.privacy_confirm');
});

// Profile update
Route::middleware(['cekToken'])->group(function () {
    Route::post('/profile/update', [updateProfil::class, 'updateProfile']);
});

// reset password
Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [ResetPasswordController::class, 'reset']);

// Logout
Route::post('/logout', [LogoutController::class, 'logout']);

// produk
Route::middleware(['cekToken', 'cekRole:petani'])->group(function () {
    Route::post('/produk', [ProdukController::class, 'create']);
Route::put('/produk/{id}', [ProdukController::class, 'update']);
Route::delete('/produk/{id}', [ProdukController::class, 'hapus']);
});
Route::get('/produk/list', [ProdukController::class, 'index']);
Route::get('/produk/{id}', [ProdukController::class, 'detail']);




// Keranjang 
Route::middleware('cekToken')->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'keranjang']);
    Route::post('/tambah/keranjang', [KeranjangController::class, 'tambahkeranjang']);
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy']);
});

// ulasan
Route::middleware(['cekToken', 'cekRole:pembeli'])->group(function () {
    Route::post('/produk/{id_produk}/ulasan', [UlasanController::class, 'store']);
    Route::patch('/ulasan/{id}', [UlasanController::class, 'update']);
});
Route::get('/produk/{id_produk}/ulasan', [UlasanController::class, 'show']);

// transaksi
Route::get('/transaksi', [TransaksiController::class, 'index']);
Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);

route::middleware(['cekToken', 'cekRole:pembeli'])->group(function () {
    Route::post('/transaksi', [TransaksiController::class, 'store']);
});

// ML
Route::middleware(['cekToken'])->group(function () {
    Route::get('/rekomendasi', [ProdukController::class, 'rekomendasi']);
});
Route::get('/data/produk', [ProdukController::class, 'dataproduk']);
Route::get('/data/histori', [SearchController::class, 'datahistory']);


// search 
Route::post('/search', [SearchController::class, 'input']);
Route::get('/user/recommendations', [SearchController::class, 'userRecommendation']);

// keuangan 
Route::prefix('keuangan')->middleware('cekToken')->group(function () {
    Route::get('/saldo', [KeuanganController::class, 'saldo']);
    Route::get('/total', [KeuanganController::class, 'totalPendapatan']);
    Route::get('/per-bulan', [KeuanganController::class, 'pendapatanPerBulan']);
    Route::get('/riwayat', [KeuanganController::class, 'riwayat']);
});



// lahan 
Route::middleware(['cekToken'])->group(function () {
    Route::post('/lahan', [LahanController::class, 'create']);
    Route::put('/lahan/{id}', [LahanController::class, 'update']);
    Route::delete('/lahan/{id}', [LahanController::class, 'destroy']);
});

Route::get('/lahan', [LahanController::class, 'index']);
Route::get('/lahan/{id}', [LahanController::class, 'show']);
