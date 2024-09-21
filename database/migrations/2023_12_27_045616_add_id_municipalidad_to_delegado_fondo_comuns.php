<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdMunicipalidadToDelegadoFondoComuns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delegado_fondo_comuns', function (Blueprint $table) {
            $table->bigInteger('id_municipalidad')->nullable();
            $table->foreign('id_municipalidad')->references('id')->on('municipalidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delegado_fondo_comuns', function (Blueprint $table) {
            //
        });
    }
}
