<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RefindsUser;
use App\Models\Alamat;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\Produk;
use App\Models\GambarProduk;
use App\Models\Favorit;
use App\Models\Transaksi;
use App\Models\Ulasan;



class SeederDbRefinds extends Seeder
{
    public function run()
    {

        /// RefindsUser & Alamat
        RefindsUser::factory(30)->create();
        Alamat::factory(120)->create();

        /// produk + gambar produk
        $jumlahProduk = 500;
        Produk::factory()->count($jumlahProduk)->create()
        ->each(function ($produk) {
            // Membuat 4 gambar untuk setiap produk
            GambarProduk::factory()->count(4)->create([
                'id_produk' => $produk->id_produk, // Menghubungkan gambar dengan produk
            ]);
        });



        /// traksaksi + ulasan
        $jumlahTransaksi = 250;
        Transaksi::factory()
        ->count($jumlahTransaksi)
        ->create()
        ->each(function ($transaksi) {
            // Memberikan kemungkinan 50% untuk membuat ulasan
            if (fake()->boolean(60)) { // 60% kemungkinan untuk memiliki ulasan
                Ulasan::factory()->create([
                    'id_transaksi' => $transaksi->id_transaksi, // Menghubungkan ulasan dengan transaksi
                ]);
            }
        });

    }
}
//
