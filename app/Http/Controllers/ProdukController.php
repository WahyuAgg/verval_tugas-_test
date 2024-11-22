<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function getAllProduk()
    {
        /**
         * Mengambil semua produk yang tersedia, diurutkan berdasarkan id_produk terbesar
         *  */
        $produk = Produk::with(['subkategori', 'alamat', 'user', 'gambarProduk'])
            ->where('status_post', 'available')
            ->orderBy('id_produk', 'desc') // Mengurutkan berdasarkan id_produk terbesar
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


    /**
     * untuk mengambil semua produk yang belum di acc oleh admin
     * lali dikirim ke dashboard admin
     */
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



    /**
     *
     * Fungsi untuk mengambil produk berdasarkan id_subkategori
     *
     */

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


    /**
     * untuk mengambil produk berdasarkan kategri
     */
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


    /**
     * fungsi untuk mengubah status postingan
     */
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

    /**
     * Method untuk mencari produk berdasarkan kata kunci
     * dan menambah search_point ke produk
     */
    public function searchProduk(Request $request)
    {
        $keywords = $request->input('keywords');

        // Pastikan 'keywords' bukan array kosong
        if (empty($keywords)) {
            return response()->json(['error' => 'Keywords are required.'], 400);
        }

        // Begin building the query with 'where' conditions for each keyword
        $query = Produk::query();
        foreach ($keywords as $keyword) {
            $query->where('nama_produk', 'LIKE', '%' . $keyword . '%');
        }

        // Fetch and increment search points in a single loop
        $products = $query->get();


        foreach ($products as $product) {
            // Increment search_point by 1 and save each product
            /** @var Produk $product */
            $product->search_point += 1;
            $product->save();
        }

        $productsResult = $query
            // ->orderBy('search_point', 'desc')
            ->get()
            ->map(function ($item) {
                return $item->getTransformedAttributes(); // Memanggil method transformasi
            });

        return response()->json($productsResult);
    }






    /**
     * fungsi untuk mendapatkan produk dari pengguna saat ini
     */
    public function getUserProduk()
    {
        try {
            // Ambil ID pengguna yang sedang login
            $userId = auth()->id();

            // Query produk berdasarkan ID pengguna
            $produkUser = Produk::where('id_user', $userId)
                ->orderBy('search_point', 'desc')
                ->get()
                ->map(function ($item) {
                    return $item->getTransformedAttributes(); // Memanggil method transformasi
                });

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



    /**
     * untuk mengambil produk yang difilter
     */
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


    /**
     * untuk mengambil produk yang paling banyak dicari, berdasarkan search point
     */
    public function getTopSearchProducts()
    {
        // Mengambil semua produk yang tersedia, diurutkan berdasarkan id_produk terbesar
        $produk = Produk::with(['subkategori', 'alamat', 'user', 'gambarProduk'])
            ->where('status_post', 'available')
            ->orderBy('search_point', 'desc')
            ->limit(100)
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


    /**
     * untuk mengambil produk berdasarkan id produk
     */
    public function getProdukById($id)
    {
        // Mencari produk berdasarkan id_produk
        $produk = Produk::with(['subkategori', 'alamat', 'user', 'gambarProduk'])
            ->where('id_produk', $id)
            // ->where('status_post', 'available') // Opsional: memastikan hanya produk "available"
            ->first();

        if (!$produk) {
            // Jika produk tidak ditemukan, kirimkan respons dengan error
            return response()->json([
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        // Transformasi atribut produk (jika ada metode transformasi di model)
        $transformedProduk = $produk->getTransformedAttributes();

        // Mengembalikan data produk sebagai respons JSON
        return response()->json($transformedProduk);
    }
}
