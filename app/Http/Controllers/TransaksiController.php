<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Make sure to import the Log facade



use App\Models\Transaksi;

class TransaksiController extends Controller
{
    // Ambil semua transaksi
    public function index()
    {
        // Ambil semua transaksi dengan relasi produk
        $transaksis = Transaksi::with('produk')->get();

        return response()->json($transaksis);
    }


    public function getTransaksiPembelian()
    {
        $userId = auth()->id();

        // Log ID
        Log::info('User ID fetching transactions:', ['user_id' => $userId]);

        // Ambil transaksi berdasarkan id_user_pembeli
        $transaksis = Transaksi::with('produk')
            ->where('id_user_pembeli', $userId)
            ->get();

        // Log transactions
        Log::info('Fetched transactions for user ID ' . $userId, ['transactions' => $transaksis]);

        return response()->json($transaksis);
    }


    public function getTransaksiPenjualan()
    {
        // Ambil id user yang sedang login

        // kelas statis | tidak digunakan
        // $userId = Auth::id();

        // method helper global dinamis
        $userId = auth()->id();

        // Ambil transaksi yang terkait dengan produk milik user saat ini
        // Ambil semua transaksi
        $transaksis = Transaksi::with('produk')

            // ...di mana produk terkait dengan transaksi tersebut...
            ->whereHas('produk', function ($query) use ($userId) {

                // ...memiliki id_user yang sama dengan userId yang diberikan.
                $query->where('id_user', $userId);
            })

            // Ambil data dari database
            ->get();

        return response()->json($transaksis);
    }
}
