<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIdRegionalToMunicipalidadIntegradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('municipalidad_integradas', function (Blueprint $table) {
            

            $table->dropColumn('id_periodo_delegado');

            $table->bigInteger('id_regional')->unsigned()->index();
            $table->bigInteger('id_periodo_comisiones')->unsigned()->index();
            $table->bigInteger('id_coodinador')->unsigned()->index();
  
            $table->foreign('')->references('id_regional')->on('regiones');
  

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('municipalidad_integradas', function (Blueprint $table) {
            //
        });
    }
}
