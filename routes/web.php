<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// CONTROLLER ACCOUNT REGSITRASION VERIVICATION
use App\Http\Controllers\AccountVerificationController;
    // Url untuk mendapatkan email verifikasi akun
Route::get('/verify_account/{token_verification}', [AccountVerificationController::class, 'verifyAccount']);
