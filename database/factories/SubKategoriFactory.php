<?php

namespace Database\Factories;

use App\Models\SubKategori;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubKategoriFactory extends Factory
{
    protected $model = SubKategori::class;

    public function definition()
    {
        return [
            'id_kategori' => Kategori::factory(),
            'nama_subkategori' => $this->faker->word,
            'deskripsi_subkategori' => $this->faker->text,
        ];
    }
}
