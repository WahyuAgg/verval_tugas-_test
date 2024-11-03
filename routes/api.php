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






use App\Http\Controllers\ProdukController;

Route::get('/produk', [ProdukController::class, 'getAllProduk']);
Route::get('/produk/kategori/', [ProdukController::class, 'getAllProduk']);

Route::get('/produk/subkategori/{id_subkategori}', [ProdukController::class, 'getProdukBySubkategori']);
Route::get('/produk/kategori/{id_kategori}', [ProdukController::class, 'getProdukByKategori']);

Route::get('/produk/user/{id_user}', [ProdukController::class, 'getProdukByUser']);
Route::get('/produk/unacc', [ProdukController::class, 'getUnACCProduk']);

// BELUM FIX TINGGAL TIDUR
Route::get('produk/acc/{bool}', [ProdukController::class, 'accProduk']);

use App\Http\Controllers\KategoriController;
Route::get('/kategori', [KategoriController::class, 'getKategori']);



Route::post('/produk/update-status/{id_produk}', [ProdukController::class, 'updateStatus']);


Route::post('/produk/search_produk', [ProdukController::class, 'searchProduk']);

Route::get('/user/produk', [ProdukController::class, 'getUserProduk'])->middleware('auth:sanctum');

use App\Http\Controllers\TransaksiController;

Route::middleware('auth:sanctum')->get('/transaksi/pembelian', [TransaksiController::class, 'getTransaksiPembelian']);
Route::middleware('auth:sanctum')->get('/transaksi/penjualan', [TransaksiController::class, 'getTransaksiPenjualan']);


// Testing Auth
Route::middleware('auth:sanctum')->get('/test-auth', function () {
    return response()->json(['user_id' => auth()->id()]);
});

// Verivikasi dengan sanctum dan mengembalikan Validasi dan UserData
Route::middleware('auth:sanctum')->get('/verify-token', function (Request $request) {
    return response()->json(['message' => 'Token is valid', 'user' => $request->user()]);
});



Route::get('/get_user', [UserController::class, 'getUserData'])->middleware('auth:sanctum');
Route::post('/update_user', [UserController::class, 'updateUserData'])->middleware('auth:sanctum');




