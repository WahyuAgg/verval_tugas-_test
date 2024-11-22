<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\GambarProduk;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ProdukUpController extends Controller
{
    /**
     * untuk mengupload produk
     */
    public function upload(Request $request)
    {
        // Validasi request
        $validatedData = $request->validate([
            'id_subkategori' => 'required|integer',
            'id_alamat' => 'required|integer',
            'id_user' => 'required|integer',
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'gambar_produk.*' => 'nullable|image|mimes:jpeg,jpg|max:2048', // Untuk gambar dalam array
        ]);

        // Simpan produk ke database
        $produk = Produk::create([
            'id_subkategori' => $validatedData['id_subkategori'],
            'id_alamat' => $validatedData['id_alamat'],
            'id_user' => $validatedData['id_user'],
            'url_teks_deskripsi' => $request->input('deskripsi'),
            'nama_produk' => $validatedData['nama_produk'],
            'harga' => $validatedData['harga'],
            'tanggal_post' => now(),
            'status_post' => 'available',
        ]);

        $uploadedImages = [];

        // Proses upload gambar dalam array
        if ($request->hasFile('gambar_produk')) {
            foreach ($request->file('gambar_produk') as $file) {
                if ($file) {
                    $path = $file->store('produk_images', 'public');
                    $uploadedImages[] = 'storage/' . $path; // Tambahkan prefix "storage/"
                }
            }
        }

        // Simpan URL gambar ke tabel GambarProduk
        foreach ($uploadedImages as $url_gambar) {
            GambarProduk::create([
                'id_produk' => $produk->id_produk,
                'url_gambar_produk' => $url_gambar,
            ]);
        }

        Log::info('Produk berhasil ditambahkan:', ['id_produk' => $produk->id_produk, 'gambar_produk' => $uploadedImages]);

        // Kirim respon sukses
        return response()->json(['message' => 'Produk berhasil disubmit!', 'data' => $produk], 201);
    }
}
