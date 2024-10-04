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
use App\Models\Pesanan;
use App\Models\Ulasan;



class SeederDbRefinds extends Seeder
{
    public function run()
    {
        // Seed the RefindsUser table
        RefindsUser::factory(10)->create();

        // Seed other related tables
        Alamat::factory(10)->create();
        Kategori::factory(5)->create();
        SubKategori::factory(10)->create();
        Produk::factory(20)->create();
        GambarProduk::factory(50)->create();
        Favorit::factory(30)->create();
        Pesanan::factory(15)->create();
        Ulasan::factory(25)->create();
    }
}
//
