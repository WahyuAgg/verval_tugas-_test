<?php

namespace Database\Factories;

use App\Models\Favorit;
use App\Models\RefindsUser;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoritFactory extends Factory
{
    protected $model = Favorit::class;

    public function definition()
    {
        return [
            'id_user' => RefindsUser::factory(),
            'id_produk' => Produk::factory(),
            'tanggal_favorit' => $this->faker->dateTime,
        ];
    }
}
