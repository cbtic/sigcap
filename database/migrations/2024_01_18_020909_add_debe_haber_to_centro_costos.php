<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDebeHaberToCentroCostos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('centro_costos', function (Blueprint $table) {
            $table->double('total_debe',15,8)->nullable();
            $table->double('total_haber',15,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('centro_costos', function (Blueprint $table) {
            //
        });
    }
}
