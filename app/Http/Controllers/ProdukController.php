<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    // Fungsi untuk mengirim semua data produk
    public function getAllProduk()
    {
        // Mengambil semua produk dari database
        $produk = Produk::with(['subkategori', 'alamat', 'user', 'gambarProduk'])->get();

        // Modifikasi untuk menambahkan list_url_gambar
        $produk->transform(function ($item) {
            // Setel atribut gambar_produk ke koleksi gambar
            $item->setAttribute('gambar_produk', $item->gambarProduk);

            // Buat list_url_gambar dengan mengonversi url_gambar_produk ke URL lengkap
            $listUrlGambar = $item->gambarProduk->map(function ($gambar) {
                return url("storage/{$gambar->url_gambar_produk}");
            });

            Log::info($listUrlGambar);

            // Tambahkan atribut baru list_url_gambar
            $item->setAttribute('list_url_gambar', $listUrlGambar);

            return $item; // Pastikan mengembalikan $item
        });

        // Convert the $produk object to JSON
        $jsonData = json_encode($produk);

        // Save the JSON data to a file in the storage directory
        Storage::disk('local')->put('produk_data.json', $jsonData);


        // Mengirimkan data ke frontend sebagai response JSON
        return response()->json($produk);
    }


    public function getUnACCProduk()
    {
        // Mengambil semua produk dari database
        $produk = Produk::with(['subkategori', 'alamat', 'user', 'gambarProduk'])
        ->where('status_post', 'unacc')
        ->get();;


        // Modifikasi untuk menambahkan list_url_gambar
        $produk->transform(function ($item) {
            // Setel atribut gambar_produk ke koleksi gambar
            $item->setAttribute('gambar_produk', $item->gambarProduk);

            // Buat list_url_gambar dengan mengonversi url_gambar_produk ke URL lengkap
            $listUrlGambar = $item->gambarProduk->map(function ($gambar) {
                return url("storage/{$gambar->url_gambar_produk}");
            });

            Log::info($listUrlGambar);

            // Tambahkan atribut baru list_url_gambar
            $item->setAttribute('list_url_gambar', $listUrlGambar);

            return $item; // Pastikan mengembalikan $item
        });

        // Convert the $produk object to JSON
        $jsonData = json_encode($produk);

        // Save the JSON data to a file in the storage directory
        Storage::disk('local')->put('produk_data.json', $jsonData);


        // Mengirimkan data ke frontend sebagai response JSON
        return response()->json($produk);
    }




    // Fungsi untuk mengirim produk berdasarkan id_subkategori
    // mirip dengan sebelumnya tapi juga menerima param $is_subkategori
    public function getProdukBySubkategori($id_subkategori)
    {
        // Mengambil produk berdasarkan id_subkategori
        $produk = Produk::with(['subkategori', 'alamat', 'user'])
            ->where('id_subkategori', $id_subkategori)
            ->get();

        // Mengirimkan data ke frontend sebagai response JSON
        return response()->json($produk);
    }

    public function getProdukByUser($id_user)
    {
        // Mengambil produk untuk user tertentu
        $produk = Produk::where('id_user', $id_user)
            ->with(['subkategori', 'alamat', 'user', 'gambarProduk'])
            ->first();

        // Log data produk dari user tersebut
        Log::info($produk);

        // Mengirimkan data produk ke frontend sebagai JSON response
        return response()->json($produk);
    }

    public function getProdukByKategori($id_kategori)
    {
        // Mengambil produk berdasarkan id_kategori dari tabel subkategori
        // Mengambil produk beserta relasi yang dibutuhkan (subkategori, alamat, user, gambarProduk)
        // Hanya produk yang memiliki id_kategori tertentu yang akan diambil
        $produk = Produk::with(['subkategori', 'alamat', 'user', 'gambarProduk']) // Mengambil relasi dari produk
            ->whereHas('subkategori', function ($query) use ($id_kategori) {
                // Filter produk berdasarkan id_kategori di tabel subkategori
                $query->where('id_kategori', $id_kategori); // Kondisi: hanya ambil subkategori yang id_kategorinya sama
            })
            ->get(); // Eksekusi query dan ambil semua hasil


        // Modifikasi untuk menambahkan list_url_gambar
        $produk->transform(function ($item) {
            $item->setAttribute('gambar_produk', $item->gambarProduk);

            // Buat list_url_gambar dengan mengonversi url_gambar_produk ke URL lengkap
            $listUrlGambar = $item->gambarProduk->map(function ($gambar) {
                return url("storage/{$gambar->url_gambar_produk}");
            });

            Log::info($listUrlGambar);

            // Tambahkan atribut baru list_url_gambar
            $item->setAttribute('list_url_gambar', $listUrlGambar);

            return $item;
        });

        // Convert the $produk object to JSON
        $jsonData = json_encode($produk);

        // Save the JSON data to a file in the storage directory
        Storage::disk('local')->put('produk_data_by_kategori.json', $jsonData);

        // Mengirimkan data ke frontend sebagai response JSON
        return response()->json($produk);
    }

    // Method to handle post status update
    public function updateStatus(Request $request, $id_produk)
    {
        // Validate input (ensure status is either 'rejected' or 'available')
        $request->validate([
            'status_post' => 'required|in:rejected,available',
        ]);

        // Find the product by ID
        $produk = Produk::find($id_produk);

        if (!$produk) {
            return response()->json(['message' => 'Produk not found'], 404);
        }

        // Update status_post based on the input
        $produk->status_post = $request->input('status_post');
        $produk->save();

        // Return response (you can customize this message)
        return response()->json([
            'message' => 'Status updated successfully',
            'produk' => $produk
        ], 200);
    }


}
