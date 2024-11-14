<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_verifications', function (Blueprint $table) {
            $table->id('id_verification');
            $table->foreignId('id_user')->constrained('refindsuser')->onDelete('cascade'); // Relasi ke tabel refindsuser
            $table->string('verification_token', 255)->unique(); // Token verifikasi unik
            $table->dateTime('expires_at'); // Tanggal kedaluwarsa token
            $table->enum('status', ['pending', 'verified', 'expired'])->default('pending'); // Status verifikasi
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_verifications');
    }
}
