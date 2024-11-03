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
        // Seed the RefindsUser table
        // RefindsUser::factory(5)->create();
        // Kategori::factory(5)->create();

        // Seed other related tables
        Alamat::factory(5)->create();
        SubKategori::factory(5)->create();
        Produk::factory(5)->create();
        GambarProduk::factory(5)->create();
        // Favorit::factory(5)->create();
        Transaksi::factory(5)->create();
        Ulasan::factory(5)->create();


        // TESTING
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
