<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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



// CONTROLLER REGISTER

use App\Http\Controllers\RegisterController;

Route::post('/register', [RegisterController::class, 'register']);



// CONTROLLER LOGIN
use App\Http\Controllers\LoginController;
Route::post('/login', [LoginController::class, 'login']);



// CONTROLLER PRODUK UP
use App\Http\Controllers\ProdukUpController;

Route::post('/produk_up', [ProdukUpController::class, 'upload']);



// CONTROLLER REFINDS USER
use App\Http\Controllers\RefindsUserController;

Route::middleware('auth:sanctum')->get('/user_data', [RefindsUserController::class, 'getUserData']);
Route::get('/get_user', [RefindsUserController::class, 'getUserData'])->middleware('auth:sanctum');
Route::post('/update_user', [RefindsUserController::class, 'updateUserData'])->middleware('auth:sanctum');



// CONTROLLER PRODUK DOWN
use App\Http\Controllers\ProdukController;

    // mengambil semua produk
Route::get('/produk', [ProdukController::class, 'getAllProduk']);

    // mengambil produk by kategori
Route::get('/produk/kategori/', [ProdukController::class, 'getAllProduk']);
Route::get('/produk/kategori/{id_kategori}', [ProdukController::class, 'getProdukByKategori']);

    // mengambil produk by sub kategori
Route::get('/produk/subkategori/{id_subkategori}', [ProdukController::class, 'getProdukBySubkategori']);

    // mengambil produk by id user
Route::get('/produk/user/{id_user}', [ProdukController::class, 'getProdukByUser']);

    // produk ACC
Route::get('/produk/unacc', [ProdukController::class, 'getUnACCProduk']);
Route::get('produk/acc/{bool}', [ProdukController::class, 'accProduk']);

Route::post('/produk/update-status/{id_produk}', [ProdukController::class, 'updateStatus']);

Route::post('/produk/search_produk', [ProdukController::class, 'searchProduk']);

Route::get('/user/produk', [ProdukController::class, 'getUserProduk'])->middleware('auth:sanctum');
Route::post('/produk/filter', [ProdukController::class, 'get_filtered_produk']);



// CONTROLLER KATEGORI
use App\Http\Controllers\KategoriController;

Route::get('/kategori', [KategoriController::class, 'getKategori']);
Route::get('/subkategori', [KategoriController::class, 'getSubkategori']);
Route::get('/initkategori', [KategoriController::class, 'updateKategoriDanSubkategori']);


// CONTROLLER TRANSAKSI
use App\Http\Controllers\TransaksiController;

Route::middleware('auth:sanctum')->get('/transaksi/pembelian', [TransaksiController::class, 'getTransaksiPembelian']);
Route::middleware('auth:sanctum')->get('/transaksi/penjualan', [TransaksiController::class, 'getTransaksiPenjualan']);



// NO CONTROLLER
Route::middleware('auth:sanctum')->get('/test-auth', function () {
    return response()->json(['user_id' => auth()->id()]);
});

// Verivikasi dengan sanctum dan mengembalikan Validasi dan UserData
Route::middleware('auth:sanctum')->get('/verify-token', function (Request $request) {
    return response()->json(['message' => 'Token is valid', 'user' => $request->user()]);
});

