<?php

namespace Database\Factories;

use App\Models\Alamat;
use App\Models\RefindsUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlamatFactory extends Factory
{
    protected $model = Alamat::class;

    public function definition()
    {
        return [
            'id_user' => RefindsUser::inRandomOrder()->first()->id_user, // Mengambil ID pengguna secara acak
            'nama_lokasi' => $this->faker->word,
            'url_map' => $this->faker->url,
            'provinsi' => $this->faker->word,
            'kota_kabupaten' => $this->faker->word,
            'kecamatan' => $this->faker->word,
            'kode_pos' => $this->faker->postcode,
            'deskripsi' => $this->faker->text,
            'is_default' => $this->faker->boolean,
        ];
    }
}
