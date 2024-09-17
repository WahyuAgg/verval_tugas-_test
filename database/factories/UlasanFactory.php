<?php

namespace Database\Factories;

use App\Models\Ulasan;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class UlasanFactory extends Factory
{
    protected $model = Ulasan::class;

    public function definition()
    {
        return [
            'id_pesanan' => Pesanan::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'komentar' => $this->faker->text,
            'tanggal_ulasan' => $this->faker->dateTime,
        ];
    }
}
