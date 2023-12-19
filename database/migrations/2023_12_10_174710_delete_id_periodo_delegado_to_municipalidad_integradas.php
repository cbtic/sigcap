<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIdPeriodoDelegadoToMunicipalidadIntegradas extends Migration
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
