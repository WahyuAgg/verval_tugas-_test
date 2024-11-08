<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    // Fungsi untuk mengambil data produk yang available
    public function getAllProduk()
    {
        // Mengambil semua produk dari database dan mentransformasikan data
        $produk = Produk::with(['subkategori', 'alamat', 'user', 'gambarProduk'])
            ->where('status_post', 'available')
            ->get()
            ->map(function ($item) {
                return $item->getTransformedAttributes(); // Memanggil method transformasi
            });

        // Convert the $produk object to JSON
        $jsonData = json_encode($produk);

        // Save the JSON data to a file in the storage directory
        Storage::disk('local')->put('produk_data.json', $jsonData);

        // Mengirimkan data ke frontend sebagai response JSON
        return response()->json($produk);
    }


    // fungsi untuk mengambil produk yang belum di acc
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
                return url("{$gambar->url_gambar_produk}");
            });

            // Log::info($listUrlGambar);

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




    // Fungsi untuk mengambil produk berdasarkan id_subkategori
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

    // fungsi untuk mengambil data produk berdasarkan id user
    public function getProdukByUser($id_user)
    {
        // Mengambil produk untuk user tertentu
        $produk = Produk::where('id_user', $id_user)
            ->with(['subkategori', 'alamat', 'user', 'gambarProduk'])
            ->first();

        // Log data produk dari user tersebut
        // Log::info($produk);

        // Mengirimkan data produk ke frontend sebagai JSON response
        return response()->json($produk);
    }


    // fungsi untuk mengambil produk berdasarkan kategori
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
                return url("{$gambar->url_gambar_produk}");
            });

            // Log::info($listUrlGambar);

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


    // fungsi untuk mengubah status postingan
    public function updateStatus(Request $request, $id_produk)
    {
        // Validasi input (pastikan status hanya 'rejected' atau 'available')
        $request->validate([
            'status_post' => 'required|in:rejected,available',
        ]);

        // Cari produk berdasarkan ID
        $produk = Produk::find($id_produk);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Perbarui status_post berdasarkan input yang diterima
        $produk->status_post = $request->input('status_post');
        $produk->save();

        // Berikan respons (pesan dapat disesuaikan)
        return response()->json([
            'message' => 'Status berhasil diperbarui',
            'produk' => $produk
        ], 200);
    }

    // Method untuk mencari produk berdasarkan kata kunci
    public function searchProduk(Request $request)
    {
        $keywords = $request->input('keywords'); // Ambil array kata kunci

        // Mulai membangun query
        $query = Produk::query();

        // Looping setiap kata kunci dan tambahkan kondisi 'where' untuk nama_produk
        foreach ($keywords as $keyword) {
            $query->where('nama_produk', 'LIKE', '%' . $keyword . '%');
        }

        // Eksekusi query dan ambil hasilnya
        $products = $query->get();

        // Kembalikan produk sebagai respons JSON
        return response()->json($products);
    }

    // Method untuk mendapatkan produk milik pengguna saat ini
    public function getUserProduk()
    {
        try {
            // Ambil ID pengguna yang sedang login
            $userId = auth()->id();

            // Query produk berdasarkan ID pengguna
            $produkUser = Produk::where('id_user', $userId)->get();

            return response()->json([
                'status' => 'success',
                'data' => $produkUser
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil produk pengguna saat ini',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // fungsi untuk mengambil produk yang difilter
    public function get_filtered_produk(Request $request)
    {
        Log::info($request);
        // Mendapatkan parameter dari permintaan
        $array_subkategori = $request->input('array_subkategori', []);
        $array_kategori = $request->input('array_kategori', []);
        $anti_kategori = $request->input('anti_kategori', false);

        Log::info('Filter subkategori', $array_subkategori);
        Log::info('Filter kategori', $array_kategori);
        Log::info('Anti Kategori:', ['anti_kategori' => $request->input('anti_kategori')]);

        // Membuat query dasar untuk model Produk dengan relasinya
        $query = Produk::with(['subkategori', 'alamat', 'user', 'gambarProduk']);

        // Menambahkan kondisi berdasarkan subkategori
        if (!empty($array_subkategori)) {
            $query->whereIn('id_subkategori', $array_subkategori);
        }

        // Menambahkan kondisi berdasarkan kategori
        if (!empty($array_kategori)) {
            $query->whereHas('subkategori.kategori', function ($query) use ($array_kategori) {
                $query->whereIn('id_kategori', $array_kategori);
            });
        }

        // Menambahkan kondisi untuk anti_kategori
        if ($anti_kategori) {
            $query->whereNull('id_subkategori');
        }

        // Menambahkan distinct untuk menghindari duplikasi
        $produks = $query->distinct('id_produk')->get()->map(function ($item) {
            return $item->getTransformedAttributes(); // Memanggil method transformasi
        });

        return response()->json([
            'status' => 'success',
            'data' => $produks,
        ]);
    }
}
