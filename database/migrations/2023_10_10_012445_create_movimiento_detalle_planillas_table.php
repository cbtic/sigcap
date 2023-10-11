<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientoDetallePlanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_detalle_planillas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_planilla_detalle')->unsigned()->index();
            $table->bigInteger('id_movimiento_planilla')->unsigned()->index();

            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_planilla_detalle')->references('id')->on('planilla_detalles');
            $table->foreign('id_movimiento_planilla')->references('id')->on('movimiento_planillas');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimiento_detalle_planillas');
    }
}
