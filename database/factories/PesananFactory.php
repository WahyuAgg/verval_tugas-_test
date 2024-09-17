<?php

namespace Database\Factories;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Alamat;
use App\Models\RefindsUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesananFactory extends Factory
{
    protected $model = Pesanan::class;

    public function definition()
    {
        return [
            'id_produk' => Produk::factory(),
            'id_alamat' => Alamat::factory(),
            'id_user_pembeli' => RefindsUser::factory(),
            'tanggal_pesanan_dibuat' => $this->faker->dateTime,
            'deskripsi' => $this->faker->text,
            'harga' => $this->faker->randomFloat(2, 1, 1000),
            'jumlah' => $this->faker->numberBetween(1, 10),
            'harga_total' => $this->faker->randomFloat(2, 1, 1000),
            'tgl_konfirm_penjual' => $this->faker->optional()->dateTime,
            'tgl_pembatalan_pembeli' => $this->faker->optional()->dateTime,
            'tgl_pembatalan_penjual' => $this->faker->optional()->dateTime,
            'tgl_konfirm_selesai_pembeli' => $this->faker->optional()->dateTime,
            'tgl_konfirm_selesai_penjual' => $this->faker->optional()->dateTime,
            'status_pesanan' => $this->faker->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
        ];
    }
}
