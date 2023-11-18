<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMuniInegradaFkToComisiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comisiones', function (Blueprint $table) {
            $table->foreign('id_municipalidad_integrada')->references('id')->on('municipalidad_integradas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comisiones', function (Blueprint $table) {
            //
        });
    }
}
