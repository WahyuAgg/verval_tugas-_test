<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SubKategori;
use App\Models\Alamat;
use App\Models\RefindsUser;


class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        // Mengambil user secara acak yang memiliki alamat
        $user = RefindsUser::has('alamat')->inRandomOrder()->first();

        // Mengambil alamat berdasarkan user yang dipilih
        $alamat = $user->alamat()->first();

        return [
            'id_subkategori' => SubKategori::inRandomOrder()->first()->id_subkategori,
             'id_alamat' => $alamat->id_alamat, // Menggunakan alamat yang valid
            'id_user' => $user->id_user, // Menyimpan id_user yang sama
            'url_teks_deskripsi' => $this->faker->text,
            'nama_produk' => $this->faker->word,
            'harga' => $this->faker->randomFloat(2, 1, 10000),
            'tanggal_post' => now(),
            'kondisi' => $this->faker->randomElement(['new', 'used']),
            'status_post' => $this->faker->randomElement(['available', 'sold', 'unacc']),
            'visibilitas' => $this->faker->boolean,
            'search_point' => $this->faker->numberBetween(1, 100),
        ];
    }
}



