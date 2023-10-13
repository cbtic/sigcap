<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodoDelegadoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodo_delegado_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_periodo_delegado')->unsigned()->index();
            $table->string('denominacion',150)->nullable();
            $table->datetime('fecha')->nullable();
            $table->string('activo',1)->nullable()->default('1');
            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_periodo_delegado')->references('id')->on('periodo_delegados');
  
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
        Schema::dropIfExists('periodo_delegado_detalles');
    }
}
