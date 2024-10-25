<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\GambarProduk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\GambarProduk;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Validation\ValidatesRequests; // Include this if needed

class ProdukUpController extends Controller
{
    use ValidatesRequests; // Optional: if you need request validation

    public function upload(Request $request)
    {
        // Validasi request
        $validatedData = $request->validate([
            'id_subkategori' => 'required|integer',
            'id_alamat' => 'required|integer',
            'id_user' => 'required|integer',
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'gambar_produk1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_produk2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_produk3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // lanjut sampai gamabr 5
        ]);
        
        // Membuat objek produk 
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

        // Array untuk menyimpan URL gambar
        $uploadedImages = [];

        // Upload gambar jika ada dan simpan ke direktori penyimpanan
        if ($request->hasFile('gambar_produk1')) {
            $path = $request->file('gambar_produk1')->store('produk_images', 'public');
            $uploadedImages[] = $path;
        }
        if ($request->hasFile('gambar_produk2')) {
            $path = $request->file('gambar_produk2')->store('produk_images', 'public');
            $uploadedImages[] = $path;
        }
        if ($request->hasFile('gambar_produk3')) {
            $path = $request->file('gambar_produk3')->store('produk_images', 'public');
            $uploadedImages[] = $path;
        }
            // Lanjut smapai gambar 5

        // Simpan URL gambar ke database
        foreach ($uploadedImages as $url_gambar) {
            GambarProduk::create([
                'id_produk' => $produk->id_produk,
                'url_gambar_produk' => $url_gambar,
            ]);
        }

        // Logging untuk memantau status request
        Log::info('Produk berhasil ditambahkan:', ['id_produk' => $produk->id_produk, 'gambar_produk' => $uploadedImages]);

        // Kirim respon sukses
        return response()->json(['message' => 'Produk berhasil disubmit!', 'data' => $produk], 201);
    }
}
