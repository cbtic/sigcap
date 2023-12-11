<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPeriodoComisionIdRegionalToMunicipalidadIntegradas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('municipalidad_integradas', function (Blueprint $table) {
            $table->bigInteger('id_periodo_comision')->unsigned()->index()->nullable();                
            $table->integer('id_regional')->nullable();           

            $table->foreign('id_regional')->references('id')->on('regiones');
            $table->foreign('id_periodo_comision')->references('id')->on('periodo_comisiones');

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
