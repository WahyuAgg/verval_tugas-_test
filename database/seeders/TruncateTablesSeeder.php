<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TruncateTablesSeeder  extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ulasan')->truncate();
        DB::table('transaksi')->truncate();
        DB::table('favorit')->truncate();
        DB::table('gambar_produk')->truncate();
        DB::table('produk')->truncate();
        DB::table('subkategori')->truncate();
        DB::table('kategori')->truncate();
        DB::table('alamat')->truncate();
        DB::table('refindsuser')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
