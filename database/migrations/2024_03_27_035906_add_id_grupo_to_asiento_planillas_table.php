<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdGrupoToAsientoPlanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asiento_planillas', function (Blueprint $table) {
            $table->bigInteger('id_grupo')->nullable();
            $table->bigInteger('id_planilla_delegado_detalle')->nullable();

            $table->foreign('id_planilla_delegado_detalle')->references('id')->on('planilla_delegado_detalles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asiento_planillas', function (Blueprint $table) {
            //
        });
    }
}
