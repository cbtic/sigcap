<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodoComisionDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodo_comision_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_periodo_comision')->unsigned()->index();
            $table->string('denominacion',150)->nullable();
            $table->datetime('fecha')->nullable();
            $table->string('activo',1)->nullable()->default('1');
            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_periodo_comision')->references('id')->on('periodo_comisiones');
  
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
        Schema::dropIfExists('periodo_comision_detalles');
    }
}
