<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comisiones', function (Blueprint $table) {
            $table->id();
            $table->integer('id_regional');
            $table->integer('id_periodo_comisiones');
            $table->integer('id_tipo_comision');
            $table->integer('id_dia_semana');
            $table->string('denominacion',250);
            $table->string('observacion',500)->nullable();
            
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_periodo_comisiones')->references('id')->on('periodo_comisiones');
            $table->foreign('id_regional')->references('id')->on('regiones');

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
        Schema::dropIfExists('comisiones');
    }
}
