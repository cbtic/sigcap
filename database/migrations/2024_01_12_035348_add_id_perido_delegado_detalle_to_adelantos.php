<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPeridoDelegadoDetalleToAdelantos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adelantos', function (Blueprint $table) {
            $table->integer('id_periodo_delegado_detalle')->nullable()->unsigned()->index();            
            $table->foreign('id_periodo_delegado_detalle')->references('id')->on('periodo_delegado_detalles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adelantos', function (Blueprint $table) {
            //
        });
    }
}
