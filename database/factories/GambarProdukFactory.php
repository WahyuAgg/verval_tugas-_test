<?php

namespace Database\Factories;

use App\Models\GambarProduk;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class GambarProdukFactory extends Factory
{
    protected $model = GambarProduk::class;

    public function definition()
    {
        return [
            'id_produk' => Produk::inRandomOrder()->first()->id_produk, // Mengambil produk secara acak
            'url_gambar_produk' => $this->faker->imageUrl, // URL gambar produk
        ];
    }
}
