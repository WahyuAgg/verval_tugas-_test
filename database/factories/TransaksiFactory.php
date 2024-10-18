<?php

namespace Database\Factories;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    protected $model = Transaksi::class;

    public function definition()
    {
        return [
            'id_produk' => \App\Models\Produk::factory(),
            'id_alamat' => \App\Models\Alamat::factory(),
            'id_user_pembeli' => \App\Models\User::factory(),
            'tanggal_transaksi_dibuat' => now(),
            'deskripsi' => $this->faker->paragraph,
            'harga' => $this->faker->randomFloat(2, 1, 10000),
            'jumlah' => $this->faker->numberBetween(1, 100),
            'harga_total' => $this->faker->randomFloat(2, 1, 100000),
            'tgl_konfirm_penjual' => null,
            'tgl_pembatalan_pembeli' => null,
            'tgl_pembatalan_penjual' => null,
            'tgl_konfirm_selesai_pembeli' => null,
            'tgl_konfirm_selesai_penjual' => null,
            'status_transaksi' => 'pending',
        ];
    }
}

