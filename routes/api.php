<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



//  register controller
use App\Http\Controllers\RegisterController;

Route::post('/register', [RegisterController::class, 'register']);


// tidak digunakan
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// login controller
Route::post('/login', [LoginController::class, 'login']);


// testing Menggunakan middleware Laravel Sanctum untuk melindungi rute ini
Route::middleware('auth:sanctum')->get('/protected-route', function (Request $request) {
    // Jika pengguna terautentikasi, akan mengembalikan respons JSON
    // dengan pesan bahwa pengguna sudah terautentikasi
    return response()->json(['message' => 'You are authenticated']);
});


//Upload produk
use App\Http\Controllers\ProdukUpController;

Route::post('/produk_up', [ProdukUpController::class, 'upload']);


use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->get('/user_data', [UserController::class, 'getUserData']);


use App\Http\Controllers\TokenController;

// In your routes/api.php
Route::middleware('auth:sanctum')->get('/verify-token', function (Request $request) {
    return response()->json(['message' => 'Token is valid', 'user' => $request->user()]);
});
