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
            'id_user' => RefindsUser::factory(),
            'nama_lokasi' => $this->faker->word,
            'nama_penerima' => $this->faker->name,
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
