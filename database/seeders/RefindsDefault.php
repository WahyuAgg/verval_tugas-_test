<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RefindsDefault extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Path file SQL
        $sqlFile = database_path('sql/refinds_default.sql');

        // Periksa apakah file SQL ada
        if (File::exists($sqlFile)) {
            // Baca isi file
            $sql = File::get($sqlFile);

            // Eksekusi query SQL
            DB::unprepared($sql);

            $this->command->info('Kategori data has been seeded successfully!');
        } else {
            $this->command->error('SQL file not found: ' . $sqlFile);
        }
    }
}
