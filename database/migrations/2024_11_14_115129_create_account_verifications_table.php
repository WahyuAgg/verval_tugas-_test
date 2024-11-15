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
        Schema::dropIfExists('account_verifications');
    }

}
