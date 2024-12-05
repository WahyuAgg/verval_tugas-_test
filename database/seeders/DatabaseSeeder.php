<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Menjalankan seeders lainnya
        $this->call([
            RefindsDefault::class,
            SeederDbRefinds::class,
        ]);

        // Eksekusi query untuk memperbarui transaksi
        DB::statement("
            UPDATE transaksi t
            JOIN (
                SELECT id_transaksi
                FROM transaksi
                ORDER BY RAND()
                LIMIT 40
            ) AS random_transaksi ON t.id_transaksi = random_transaksi.id_transaksi
            SET t.id_user_pembeli = FLOOR(1 + (RAND() * 2)); -- 1 atau 2
        ");

        // Eksekusi query untuk memperbarui produk
        DB::statement("
            UPDATE produk p
            JOIN (
                SELECT id_produk
                FROM produk
                ORDER BY RAND()
                LIMIT 50
            ) AS random_produk ON p.id_produk = random_produk.id_produk
            SET p.id_user = FLOOR(1 + (RAND() * 2)); -- 1 atau 2
        ");
    }
}

