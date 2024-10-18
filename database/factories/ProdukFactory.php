<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        return [
            'id_subkategori' => \App\Models\SubKategori::factory(),
            'id_alamat' => \App\Models\Alamat::factory(),
            'id_user' => \App\Models\User::factory(),
            'url_teks_deskripsi' => $this->faker->url,
            'nama_produk' => $this->faker->word,
            'harga' => $this->faker->randomFloat(2, 1, 10000),
            'jumlah' => $this->faker->numberBetween(1, 100),
            'tanggal_post' => now(),
            'kondisi' => $this->faker->randomElement(['new', 'used']),
            'status_post' => $this->faker->randomElement(['available', 'sold', 'unacc']),
            'visibilitas' => $this->faker->boolean,
        ];
    }
}
