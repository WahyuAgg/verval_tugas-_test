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

    //// update user data
    // 'nama_akun' => 'required|string|max:255',
    // 'nama_asli_user' => 'required|string|max:255',
    // 'email' => 'required|email|max:255|unique:refindsuser,email,' . $user->id_user . ',id_user',
    // 'no_telepon' => 'required|string|max:15',
    // 'url_foto_profil' => 'nullable|url|max:255',
    // 'foto_profil' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Untuk upload file gambar
Route::post('/update_user', [RefindsUserController::class, 'updateUserData'])->middleware('auth:sanctum');



// CONTROLLER PRODUK GET
use App\Http\Controllers\ProdukController;

    // mengambil semua produk
Route::get('/produk', [ProdukController::class, 'getAllProduk']);
    // menagmbil produk berdasarkan produk id
Route::get('/produk/{id}', [ProdukController::class, 'getProdukById']);

    // mengambil produk by kategori
Route::get('/produk/kategori/', [ProdukController::class, 'getAllProduk']);
Route::get('/produk/kategori/{id_kategori}', [ProdukController::class, 'getProdukByKategori']);

    // mengambil produk by sub kategori
Route::get('/produk/subkategori/{id_subkategori}', [ProdukController::class, 'getProdukBySubkategori']);

    // mengambil produk by id user, param = id_user
Route::get('/produk/user/{id_user}', [ProdukController::class, 'getProdukByUser']);

    // get produks by user id / param = $request->is_user / dengan auth
Route::get('/user/produk', [ProdukController::class, 'getUserProduk'])->middleware('auth:sanctum');


    // get produk belum di acc
Route::get('/produk/unacc', [ProdukController::class, 'getUnACCProduk']);

    // Set acc/reject produk
Route::get('produk/acc/{bool}', [ProdukController::class, 'accProduk']);

Route::post('/produk/update-status/{id_produk}', [ProdukController::class, 'updateStatus']);

    // Get Search produk
    // param = "keywords" []
Route::post('/produk/search_produk', [ProdukController::class, 'searchProduk']);


    //// filter produk
    // $request->input('array_subkategori', []);
    // $request->input('array_kategori', []);
    // $request->input('anti_kategori', false);
Route::post('/produk/filter', [ProdukController::class, 'get_filtered_produk']);

    // get produk by top search
Route::get('/top-products', [ProdukController::class, 'getTopSearchProducts']);





// CONTROLLER KATEGORI
use App\Http\Controllers\KategoriController;

Route::get('/kategori', [KategoriController::class, 'getKategori']);
Route::get('/subkategori', [KategoriController::class, 'getSubkategori']);


// CONTROLLER TRANSAKSI
use App\Http\Controllers\TransaksiController;
    // get trasaksis pembelian
Route::middleware('auth:sanctum')->get('/transaksi/pembelian', [TransaksiController::class, 'getTransaksiPembelian']);
    // get transaksis penjualan
Route::middleware('auth:sanctum')->get('/transaksi/penjualan', [TransaksiController::class, 'getTransaksiPenjualan']);

    // pembatalan dan konfirmasi transaksi
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/transaksi/{id}/batalkan-penjual', [TransaksiController::class, 'batalkanOlehPenjual']);
    Route::get('/transaksi/{id}/batalkan-pembeli', [TransaksiController::class, 'batalkanOlehPembeli']);
    Route::get('/transaksi/{id}/konfirmasi-selesai-penjual', [TransaksiController::class, 'konfirmasiSelesaiOlehPenjual']);
    Route::get('/transaksi/{id}/konfirmasi-selesai-pembeli', [TransaksiController::class, 'konfirmasiSelesaiOlehPembeli']);
});
    // Membuat traksaksi
    // contoh penggunaan: GET /transaksi/create?id_produk=1&id_alamat=2&id_user_pembeli=3

Route::get('/transaksi/create', [TransaksiController::class, 'createTransaksi']);






// NO CONTROLLER
Route::middleware('auth:sanctum')->get('/test-auth', function () {
    return response()->json(['user_id' => auth()->id()]);
});


Route::middleware('auth:sanctum')->get('/verify-token', function (Request $request) {
    return response()->json(['message' => 'Token is valid', 'user' => $request->user()]);
});


// CONTROLLER ACCOUNT REGSITRASION VERIVICATION
use App\Http\Controllers\AccountVerificationController;
    // Url untuk mendapatkan email verifikasi akun
Route::get('/send-verification-token/{id_user}', [AccountVerificationController::class, 'sendVerificationToken']);




// CONTROLLER DEBUG
use App\Http\Controllers\TestingController;

Route::get('/test-increment/{id}', [TestingController::class, 'testIncrement']);


// CONTROLLER ULASAN
use App\Http\Controllers\UlasanController;
    // untuk membuat ulasan
Route::middleware('auth:sanctum')->post('/ulasan', [UlasanController::class, 'store']);


