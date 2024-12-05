<?php

namespace Database\Seeders;

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
        // Daftar file SQL yang akan dieksekusi
        $sqlFiles = [
            'sql/refinds_default.sql', // File SQL untuk kategori
            'sql/refinds_user.sql',    // File SQL untuk user
        ];

        foreach ($sqlFiles as $file) {
            // Path lengkap file SQL
            $sqlFile = database_path($file);

            // Periksa apakah file SQL ada
            if (File::exists($sqlFile)) {
                // Baca isi file
                $sql = File::get($sqlFile);

                // Eksekusi query SQL
                DB::unprepared($sql);

                $this->command->info(basename($file) . ' has been seeded successfully!');
            } else {
                $this->command->error('SQL file not found: ' . $sqlFile);
            }
        }
    }
}
