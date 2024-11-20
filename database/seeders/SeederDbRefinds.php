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
        //// HARD CODED
        // Kategori::factory(0)->create();
        // SubKategori::factory(0)->create();

        //// FACTORIES
        RefindsUser::factory(10)->create();
        Alamat::factory(30)->create();

        /// produk + gambar produk
        $jumlahProduk = 30;
        Produk::factory()->count($jumlahProduk)->create()->each(function ($produk) {
            // Membuat 4 gambar untuk setiap produk
            GambarProduk::factory()->count(4)->create([
                'id_produk' => $produk->id_produk, // Menghubungkan gambar dengan produk
            ]);
        });
        
        // traksaksi + ulasan
        Transaksi::factory()
        ->count(60)
        ->create()
        ->each(function ($transaksi) {
            // Memberikan kemungkinan 50% untuk membuat ulasan
            if (fake()->boolean(50)) { // 50% kemungkinan untuk memiliki ulasan
                Ulasan::factory()->create([
                    'id_transaksi' => $transaksi->id_transaksi, // Menghubungkan ulasan dengan transaksi
                ]);
            }
        });



        //// ON PROGRES

        // Favorit::factory(5)->create();



        ////////////// TESTING
        // Seed the RefindsUser table
        // RefindsUser::factory(50)->create();
        // Kategori::factory(50)->create();

        // // Seed other related tables
        // Alamat::factory(50)->create();
        // SubKategori::factory(50)->create();
        // Produk::factory(50)->create();
        // GambarProduk::factory(50)->create();
        // Favorit::factory(50)->create();
        // Transaksi::factory(50)->create();
        // Ulasan::factory(50)->create();
    }
}
//
