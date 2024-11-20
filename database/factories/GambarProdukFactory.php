<?php

namespace Database\Factories;

use App\Models\GambarProduk;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Facades\Storage;

class GambarProdukFactory extends Factory
{
    protected $model = GambarProduk::class;

    public function definition()
    {
        // Ambil semua file di folder storage/app/public/produk_images
        $files = Storage::files('public/produk_images');

        // Pilih file secara acak
        $randomFile = $files[array_rand($files)];

        // Ubah path menjadi URL yang sesuai untuk disimpan di database
        // Menghapus prefix 'public/' agar menjadi 'storage/...'
        $urlGambarProduk = str_replace('public/', 'storage/', $randomFile);

        return [
            'id_produk' => Produk::inRandomOrder()->first()->id_produk, // Mengambil produk secara acak
            'url_gambar_produk' => $urlGambarProduk, // URL gambar produk
        ];
    }
}

