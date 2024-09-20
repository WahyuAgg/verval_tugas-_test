<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\SubKategori;
use App\Models\Alamat;
use App\Models\RefindsUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        return [
            'id_subkategori' => SubKategori::factory(),
            'id_alamat' => Alamat::factory(),
            'id_user' => RefindsUser::factory(),
            'url_teks_deskripsi' => $this->faker->text,
            'nama_produk' => $this->faker->word,
            'harga' => $this->faker->randomFloat(2, 1, 1000),
            'jumlah' => $this->faker->numberBetween(1, 100),
            'tanggal_post' => $this->faker->dateTime,
            'kondisi' => $this->faker->randomElement(['new', 'used']),
            'status_post' => $this->faker->randomElement(['available', 'sold', 'hidden']),
            'visibilitas' => $this ->faker ->randomElement([1,0]),
        ];
    }
}
