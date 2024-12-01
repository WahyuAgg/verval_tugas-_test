<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\Alamat;
use App\Models\Transaksi;
use App\Models\RefindsUser; // pastikan untuk menggunakan model yang benar
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    protected $model = Transaksi::class;

    public function definition()
    {
        // Mengambil produk secara acak
        $produk = Produk::inRandomOrder()->first();

        // Mengambil alamat berdasarkan produk yang dipilih
        $alamat = Alamat::where('id_user', $produk->id_user)->where('id_alamat', $produk->id_alamat)->first();

        // Mengambil user pembeli secara acak
        $userPembeli = RefindsUser::inRandomOrder()->first();

        return [
            'id_produk' => $produk->id_produk,
            'id_alamat' => $alamat ? $alamat->id_alamat : null, // Mengambil id_alamat yang sesuai, atau null jika tidak ada
            'id_user_pembeli' => $userPembeli->id_user, // Mengambil id_user secara acak
            'tanggal_transaksi_dibuat' => now(),
            'deskripsi' => $this->faker->paragraph,
            // 'harga' => $this->faker->randomFloat(2, 1, 10000),
            'tgl_konfirm_penjual' => $this->faker->optional(0.3)->dateTime(), // 30% kemungkinan mendapatkan tanggal
            'tgl_pembatalan_pembeli' => $this->faker->optional(0.2)->dateTime(), // 20% kemungkinan mendapatkan tanggal
            'tgl_pembatalan_penjual' => $this->faker->optional(0.2)->dateTime(), // 20% kemungkinan mendapatkan tanggal
            'tgl_konfirm_selesai_pembeli' => $this->faker->optional(0.2)->dateTime(), // 20% kemungkinan mendapatkan tanggal
            'tgl_konfirm_selesai_penjual' => $this->faker->optional(0.2)->dateTime(), // 20% kemungkinan mendapatkan tanggal
            'status_transaksi' => 'pending',
        ];
    }
}


