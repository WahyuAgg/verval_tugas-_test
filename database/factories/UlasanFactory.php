<?php

namespace Database\Factories;

use App\Models\Ulasan;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;


class UlasanFactory extends Factory
{
    protected $model = Ulasan::class;

    public function definition()
    {
        return [
            'id_transaksi' => Transaksi::inRandomOrder()->first()->id_transaksi, // Mengambil transaksi secara acak
            'rating' => $this->faker->numberBetween(1, 5), // Menggunakan $this->faker
            'komentar' => $this->faker->text,
            'tanggal_ulasan' => $this->faker->dateTime,
        ];
    }
}

