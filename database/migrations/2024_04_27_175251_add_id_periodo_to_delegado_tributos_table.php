<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPeriodoToDelegadoTributosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delegado_tributos', function (Blueprint $table) {
            $table->bigInteger('id_periodo_comision')->nullable();
            $table->bigInteger('anio')->nullable();
            
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
        Schema::table('delegado_tributos', function (Blueprint $table) {
            //
        });
    }
}
