<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanillaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planilla_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_planilla')->unsigned()->index();
            $table->bigInteger('id_agremiado')->unsigned()->index();
            $table->bigInteger('id_plan_contgable')->unsigned()->index();
            $table->string('ruta_compronante',150)->nullable();
            $table->string('voucher_codigo',150)->nullable();
            $table->bigInteger('id_banco')->unsigned()->index();
            $table->date('voucher_fecha')->nullable();
            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_planilla')->references('id')->on('planillas');
            $table->foreign('id_agremiado')->references('id')->on('agremiados');
 
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
        Schema::dropIfExists('planilla_detalles');
    }
}
