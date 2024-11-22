<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Make sure to import the Log facade



use App\Models\Transaksi;

class TransaksiController extends Controller

{
    /**
     * Membuat transaksi baru berdasarkan parameter URL.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTransaksi(Request $request)
    {
        // Validasi input dari URL parameter
        $validator = Validator::make($request->query(), [
            'id_produk' => 'required|exists:produk,id_produk',
            'id_alamat' => 'required|exists:alamat,id_alamat',
            'id_user_pembeli' => 'required|exists:refindsuser,id_user',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ambil data produk berdasarkan id_produk dari parameter URL
        $produk = Produk::findOrFail($request->query('id_produk'));


        // Buat transaksi baru
        $transaksi = Transaksi::create([
            'id_produk' => $request->query('id_produk'),
            'id_alamat' => $request->query('id_alamat'),
            'id_user_pembeli' => $request->query('id_user_pembeli'),
            'tanggal_transaksi_dibuat' => now(),
            'deskripsi' => $produk->deskripsi ?? '', // Jika ada deskripsi produk
            'harga' => $produk->harga,
            'status_transaksi' => 'pending', // Status default transaksi
        ]);

        return response()->json([
            'message' => 'Transaksi berhasil dibuat.',
            'transaksi' => $transaksi,
        ], 201);
    }



    /**
     * untuk data trasnsaksi yang terkait dengan produk
     */
    public function index()
    {
        // Ambil semua transaksi dengan relasi produk
        $transaksis = Transaksi::with('produk')->get();

        return response()->json($transaksis);
    }


    /**
     * untuk mengambil data transaksi pembelian oleh user saat ini
     */
    public function getTransaksiPembelian()
    {
        $userId = auth()->id();

        // Log ID
        Log::info('User ID fetching transactions:', ['user_id' => $userId]);

        // Ambil transaksi berdasarkan id_user_pembeli dengan gambarProduk
        $transaksis = Transaksi::with(['produk.gambarProduk'])
            ->where('id_user_pembeli', $userId)
            ->get();

        // Log transactions
        Log::info('Fetched transactions for user ID ' . $userId, ['transactions' => $transaksis]);

        // Map hasil transaksi untuk menerapkan transformasi pada setiap produk
        $transaksis->each(function ($transaksi) {
            if ($transaksi->produk) {

                // Menambahkan penjelasan ke Intelephense
                /**
                 * @var \App\Models\Transaksi $transaksi
                 * @property \App\Models\Produk $produk
                 */
                $transaksi->produk = $transaksi->produk->getTransformedAttributes();
            }
        });

        return response()->json($transaksis);
    }


    /**
     * untuk mengambil data transaksi penjulan oleh user saat ini
     */
    public function getTransaksiPenjualan()
    {
        // Ambil ID user saat ini
        $userId = auth()->id();

        // Ambil transaksi yang terkait dengan produk milik user saat ini
        $transaksis = Transaksi::with(['produk.gambarProduk']) // Pastikan gambarProduk ikut dimuat
            ->whereHas('produk', function ($query) use ($userId) {
                $query->where('id_user', $userId);
            })
            ->get();


        $transaksis->each(function ($transaksi) {
            if ($transaksi->produk) {

                // Menambahkan penjelasan ke Intelephense
                /**
                 * @var \App\Models\Transaksi $transaksi
                 * @property \App\Models\Produk $produk
                 */
                $transaksi->produk = $transaksi->produk->getTransformedAttributes();
            }
        });

        return response()->json($transaksis);
    }



    // Endpoint untuk terima pesanan oleh penjual
    public function konfirmasiPenjual($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->konfirmasiPenjual();

        return response()->json(['message' => 'Transaksi berhasil dikonfirmasi oleh penjual', 'transaksi' => $transaksi]);
    }

    // Endpoint untuk pembatalan oleh penjual
    public function batalkanOlehPenjual($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->batalkanOlehPenjual();

        return response()->json(['message' => 'Transaksi berhasil dibatalkan oleh penjual', 'transaksi' => $transaksi]);
    }

    // Endpoint untuk pembatalan oleh pembeli
    public function batalkanOlehPembeli($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->batalkanOlehPembeli();

        return response()->json(['message' => 'Transaksi berhasil dibatalkan oleh pembeli', 'transaksi' => $transaksi]);
    }

    // Endpoint untuk konfirmasi selesai oleh penjual
    public function konfirmasiSelesaiOlehPenjual($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->konfirmasiSelesaiOlehPenjual();

        return response()->json(['message' => 'Transaksi berhasil dikonfirmasi selesai oleh penjual', 'transaksi' => $transaksi]);
    }

    // Endpoint untuk konfirmasi selesai oleh pembeli
    public function konfirmasiSelesaiOlehPembeli($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->konfirmasiSelesaiOlehPembeli();

        return response()->json(['message' => 'Transaksi berhasil dikonfirmasi selesai oleh pembeli', 'transaksi' => $transaksi]);
    }
}
