<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerificationDateToRefindsuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refindsuser', function (Blueprint $table) {
            $table->dateTime('verification_date')->nullable()->after('terakhir_login');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refindsuser', function (Blueprint $table) {
            $table->dropColumn('verification_date');
        });
    }
}
