<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class AdminACCController extends Controller
{
    //
    public function getUnACC()
    {
        // Ambil semua produk dengan status_post "unacc"
        $unaccProducts = Produk::where('status_post', 'unacc')->get();

        // Return data produk yang ditemukan dalam bentuk JSON
    }
}
