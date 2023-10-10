<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipalidadIntegradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipalidad_integradas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_periodo_delegado')->unsigned()->index();
            $table->string('denominacion',150)->nullable();
            $table->bigInteger('id_vigencia')->unsigned()->index();
            $table->bigInteger('id_tipo_agrupacion')->unsigned()->index();
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
        Schema::dropIfExists('municipalidad_integradas');
    }
}
