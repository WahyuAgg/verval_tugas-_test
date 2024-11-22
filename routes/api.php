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




// ------------------------------------------------------------------------------------------------------------------------------
// CONTROLLER REGISTER

use App\Http\Controllers\RegisterController;

    /// untuk registrasi
    // $validator = Validator::make($request->all(), [
    //     'nama_akun' => 'required|string|max:255',
    //     'nama_asli_user' => 'required|string|max:255',
    //     'email' => 'required|string|email|max:255|unique:refindsuser',
    //     'password' => 'required|string|confirmed',
    // ]);
Route::post('/register', [RegisterController::class, 'register']);


// ------------------------------------------------------------------------------------------------------------------------------
// CONTROLLER LOGIN
use App\Http\Controllers\LoginController;

    /// untuk login
    // $request->validate([
    //     'email' => 'required|email|string',
    //     'password' => 'required|string',
    // ]);
Route::post('/login', [LoginController::class, 'login']);


// ------------------------------------------------------------------------------------------------------------------------------
// CONTROLLER PRODUK UP
use App\Http\Controllers\ProdukUpController;

    /// untuk mengupload produk baru
    // $validatedData = $request->validate([
    //     'id_subkategori' => 'required|integer',
    //     'id_alamat' => 'required|integer',
    //     'id_user' => 'required|integer',
    //     'nama_produk' => 'required|string|max:100',
    //     'harga' => 'required|numeric|min:0',
    //     'gambar_produk.*' => 'nullable|image|mimes:jpeg,jpg|max:2048', // Untuk gambar dalam array
    // ]);
Route::post('/produk_up', [ProdukUpController::class, 'upload']);


// ------------------------------------------------------------------------------------------------------------------------------
// CONTROLLER REFINDS USER
use App\Http\Controllers\RefindsUserController;

    // untuk mendapatkan user sata , berdasarkan token yg di otentifikasi
Route::middleware('auth:sanctum')->get('/user_data', [RefindsUserController::class, 'getUserData']);
    // untuk mendapatkan user sata , berdasarkan token yg di otentifikasi
Route::get('/get_user', [RefindsUserController::class, 'getUserData'])->middleware('auth:sanctum');

    /// Untuk update data user
    // $request->validate([
    //     'nama_akun' => 'required|string|max:255',
    //     'nama_asli_user' => 'required|string|max:255',
    //     'email' => 'required|email|max:255|unique:refindsuser,email,' . $user->id_user . ',id_user',
    //     'no_telepon' => 'required|string|max:15',
    //     'foto_profil' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
    // ]);
Route::post('/update_user', [RefindsUserController::class, 'updateUserData'])->middleware('auth:sanctum');



// ------------------------------------------------------------------------------------------------------------------------------
// CONTROLLER PRODUK GET
use App\Http\Controllers\ProdukController;

    // mengambil semua produk
Route::get('/produk', [ProdukController::class, 'getAllProduk']);
    // menagmbil produk berdasarkan produk id
Route::get('/produk/{id}', [ProdukController::class, 'getProdukById']);

    // mengambil produk by kategori, mengambil semua produk jika tidak ada id_kategori yang disertakan
Route::get('/produk/kategori/', [ProdukController::class, 'getAllProduk']);
    // mengambil produk by id_subkategori
Route::get('/produk/kategori/{id_kategori}', [ProdukController::class, 'getProdukByKategori']);

    // mengambil produk by sub kategori
Route::get('/produk/subkategori/{id_subkategori}', [ProdukController::class, 'getProdukBySubkategori']);

    // mengambil produk by id user
Route::get('/produk/user/{id_user}', [ProdukController::class, 'getProdukByUser']);

    // get produks by id_user
    // $request->id_user
Route::get('/user/produk', [ProdukController::class, 'getUserProduk'])->middleware('auth:sanctum');


    // get produk belum di acc
Route::get('/produk/unacc', [ProdukController::class, 'getUnACCProduk']);

    // Set acc/reject produk
    // true = acc, false = reject
Route::get('produk/acc/{bool}', [ProdukController::class, 'accProduk']);


    /// untuk custom update status
    // $id_produk
    // $request->validate([
    //     'status_post' => 'required|in:rejected,available',
    // ]);
Route::post('/produk/update-status/{id_produk}', [ProdukController::class, 'updateStatus']);

// Get Search produk
// $keywords = $request->input('keywords');
Route::post('/produk/search_produk', [ProdukController::class, 'searchProduk']);


    /// filter produk, parameter Request yg berisi:
    // $request->input('array_subkategori', []);
    // $request->input('array_kategori', []);
    // $request->input('anti_kategori', false);
Route::post('/produk/filter', [ProdukController::class, 'get_filtered_produk']);

    // get produk by top search
Route::get('/top-products', [ProdukController::class, 'getTopSearchProducts']);




// ------------------------------------------------------------------------------------------------------------------------------
// CONTROLLER KATEGORI
use App\Http\Controllers\KategoriController;
    // utnuk mendapatkan daftar kategori
Route::get('/kategori', [KategoriController::class, 'getKategori']);
    // untuk mendapatkan daftar sibkategori
Route::get('/subkategori', [KategoriController::class, 'getSubkategori']);



// ------------------------------------------------------------------------------------------------------------------------------
// CONTROLLER TRANSAKSI
use App\Http\Controllers\TransaksiController;
    // get trasaksis pembelian
Route::middleware('auth:sanctum')->get('/transaksi/pembelian', [TransaksiController::class, 'getTransaksiPembelian']);
    // get transaksis penjualan
Route::middleware('auth:sanctum')->get('/transaksi/penjualan', [TransaksiController::class, 'getTransaksiPenjualan']);

    // pembatalan dan konfirmasi transaksi, di group route ini {id} merupakan id_transaksi
Route::middleware('auth:sanctum')->group(function () {

    // pembatalan transaksi oleh penjual
    Route::get('/transaksi/{id}/batalkan-penjual', [TransaksiController::class, 'batalkanOlehPenjual']);

    // pembatalan transaksi oleh penjual
    Route::get('/transaksi/{id}/batalkan-pembeli', [TransaksiController::class, 'batalkanOlehPembeli']);

    // konfirmasi penyelesaian pesana oleh penjual
    Route::get('/transaksi/{id}/konfirmasi-selesai-penjual', [TransaksiController::class, 'konfirmasiSelesaiOlehPenjual']);

    // konfirmasi penyelesaian pesana oleh pembeli
    Route::get('/transaksi/{id}/konfirmasi-selesai-pembeli', [TransaksiController::class, 'konfirmasiSelesaiOlehPembeli']);
});
    // Membuat traksaksi
    // contoh penggunaan: GET /transaksi/create?id_produk=1&id_alamat=2&id_user_pembeli=3

Route::get('/transaksi/create', [TransaksiController::class, 'createTransaksi']);



// ------------------------------------------------------------------------------------------------------------------------------
// NO CONTROLLER
    // untuk testing
Route::middleware('auth:sanctum')->get('/test-auth', function () {
    return response()->json(['user_id' => auth()->id()]);
});

    // untuk verifikasi token
Route::middleware('auth:sanctum')->get('/verify-token', function (Request $request) {
    return response()->json(['message' => 'Token is valid', 'user' => $request->user()]);
});
    // untuk mengambil user dengan token
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ------------------------------------------------------------------------------------------------------------------------------
// CONTROLLER ACCOUNT REGSITRASION VERIVICATION
use App\Http\Controllers\AccountVerificationController;
    // Url untuk mendapatkan email verifikasi akun
Route::get('/send-verification-token/{id_user}', [AccountVerificationController::class, 'sendVerificationToken']);



// ------------------------------------------------------------------------------------------------------------------------------
// CONTROLLER TESTING
use App\Http\Controllers\TestingController;
    // testing increment
Route::get('/test-increment/{id}', [TestingController::class, 'testIncrement']);

// ------------------------------------------------------------------------------------------------------------------------------
// CONTROLLER ULASAN
use App\Http\Controllers\UlasanController;

    // untuk membuat ulasan
    // $request->validate([
    //     'id_transaksi' => 'required|exists:transaksi,id_transaksi',
    //     'rating' => 'required|integer|min:1|max:5',
    //     'komentar' => 'required|string',
    //     'tanggal_ulasan' => 'required|date',
    // ]);
Route::middleware('auth:sanctum')->post('/ulasan', [UlasanController::class, 'store']);


