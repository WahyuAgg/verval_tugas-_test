<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Menjalankan seeders lainnya, dengan penanganan error untuk RefindsDefault
        try {
            $this->call(RefindsDefault::class);
        } catch (\Exception $e) {
            Log::error('Error in RefindsDefault seeder: ' . $e->getMessage());
            // Menangani error dan melanjutkan ke seeder berikutnya
        }

        // Menjalankan SeederDbRefinds tanpa perlu memeriksa error
        try {
            $this->call(SeederDbRefinds::class);
        } catch (\Exception $e) {
            Log::error('Error in SeederDbRefinds seeder: ' . $e->getMessage());
            // Menangani error dan melanjutkan ke tahapan berikutnya
        }

        // Eksekusi query untuk memperbarui transaksi
        try {
            DB::statement("UPDATE transaksi t
                JOIN (
                    SELECT id_transaksi
                    FROM transaksi
                    ORDER BY RAND()
                    LIMIT 40
                ) AS random_transaksi ON t.id_transaksi = random_transaksi.id_transaksi
                SET t.id_user_pembeli = FLOOR(1 + (RAND() * 2));");
        } catch (\Exception $e) {
            Log::error('Error updating transaksi: ' . $e->getMessage());
        }

        // Eksekusi query untuk memperbarui produk
        try {
            DB::statement("UPDATE produk p
                JOIN (
                    SELECT id_produk
                    FROM produk
                    ORDER BY RAND()
                    LIMIT 50
                ) AS random_produk ON p.id_produk = random_produk.id_produk
                SET p.id_user = FLOOR(1 + (RAND() * 2));");
        } catch (\Exception $e) {
            Log::error('Error updating produk: ' . $e->getMessage());
        }
    }
}

