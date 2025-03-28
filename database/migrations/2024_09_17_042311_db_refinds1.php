<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Add this for DB::raw

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        // Create REFINDSUSER table
        Schema::create('refindsuser', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_akun', 100)->unique();
            $table->string('nama_asli_user', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('no_telepon', 20)->nullable();
            $table->dateTime('tanggal_registrasi')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->string('url_foto_profil', 255)->nullable();
            $table->enum('status_akun', ['active', 'inactive', 'suspended'])->default('active');
            $table->enum('level_account', ['user', 'admin', 'superadmin'])->default('user');
            $table->dateTime('terakhir_login')->nullable();
            $table->dateTime('verification_date')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        // Create ALAMAT table
        Schema::create('alamat', function (Blueprint $table) {
            $table->id('id_alamat');
            $table->unsignedBigInteger('id_user');
            $table->string('nama_lokasi', 100);
            $table->string('url_map', 255)->nullable();
            $table->string('provinsi', 50);
            $table->string('kota_kabupaten', 50);
            $table->string('kecamatan', 50);
            $table->string('kode_pos', 10);
            $table->text('deskripsi')->nullable();
            $table->boolean('is_default')->default(false);
            $table->foreign('id_user')->references('id_user')->on('refindsuser');
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        // Create KATEGORI table
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori', 100);
            $table->text('deskripsi_kategori')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        // Create SUBKATEGORI table
        Schema::create('subkategori', function (Blueprint $table) {
            $table->id('id_subkategori');
            $table->unsignedBigInteger('id_kategori');
            $table->string('nama_subkategori', 100);
            $table->text('deskripsi_subkategori')->nullable();
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori');
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        // Create PRODUK table
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->unsignedBigInteger('id_subkategori');
            $table->unsignedBigInteger('id_alamat');
            $table->unsignedBigInteger('id_user');
            $table->string('url_teks_deskripsi', 255)->nullable();
            $table->string('nama_produk', 100);
            $table->decimal('harga', 15, 2)->check('harga > 0');
            $table->dateTime('tanggal_post')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->enum('kondisi', ['new', 'used'])->default('used');
            $table->enum('status_post', ['available', 'sold', 'unacc', 'rejected'])->default('unacc');
            $table->integer('search_point')->nullable()->default(0);
            $table->boolean('visibilitas')->nullable()->default(null);
            $table->foreign('id_subkategori')->references('id_subkategori')->on('subkategori');
            $table->foreign('id_alamat')->references('id_alamat')->on('alamat');
            $table->foreign('id_user')->references('id_user')->on('refindsuser');
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        // Create GAMBAR_PRODUK table
        Schema::create('gambar_produk', function (Blueprint $table) {
            $table->id('id_gambar_produk');
            $table->unsignedBigInteger('id_produk');
            $table->string('url_gambar_produk', 255);
            $table->foreign('id_produk')->references('id_produk')->on('produk');
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        // Create FAVORIT table
        Schema::create('favorit', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_produk');
            $table->dateTime('tanggal_favorit')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->primary(['id_user', 'id_produk']);
            $table->foreign('id_user')->references('id_user')->on('refindsuser');
            $table->foreign('id_produk')->references('id_produk')->on('produk');
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        // Create Transaksi table
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_alamat');
            $table->unsignedBigInteger('id_user_pembeli');
            $table->dateTime('tanggal_transaksi_dibuat')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->text('deskripsi')->nullable();
            // $table->decimal('harga', 15, 2)->check('harga > 0');
            $table->dateTime('tgl_konfirm_penjual')->nullable();
            $table->dateTime('tgl_pembatalan_pembeli')->nullable();
            $table->dateTime('tgl_pembatalan_penjual')->nullable();
            $table->dateTime('tgl_konfirm_selesai_pembeli')->nullable();
            $table->dateTime('tgl_konfirm_selesai_penjual')->nullable();
            $table->enum('status_transaksi', ['pending', 'acc', 'completed', 'cancelled'])->default('pending');
            $table->foreign('id_produk')->references('id_produk')->on('produk');
            $table->foreign('id_alamat')->references('id_alamat')->on('alamat');
            $table->foreign('id_user_pembeli')->references('id_user')->on('refindsuser');
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        // Create ULASAN table
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->unsignedBigInteger('id_transaksi');
            $table->integer('rating')->check('rating BETWEEN 1 AND 5');
            $table->text('komentar')->nullable();
            $table->dateTime('tanggal_ulasan')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi');
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        // Account verification
        Schema::create('account_verifications', function (Blueprint $table) {
            $table->id('id_verification');
            $table->foreignId('id_user')
                  ->constrained('refindsuser', 'id_user')
                  ->onDelete('cascade');
            $table->string('verification_token', 255)->unique();
            $table->dateTime('expires_at');
            $table->enum('status', ['pending', 'verified', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ulasan');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('favorit');
        Schema::dropIfExists('gambar_produk');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('subkategori');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('alamat');
        Schema::dropIfExists('account_verifications');
        Schema::dropIfExists('refindsuser');


    }
};
