<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMucipalidadDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mucipalidad_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_municipalidad')->unsigned()->index();
            $table->bigInteger('id_municipalidad_integrada')->unsigned()->index();
            
            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_municipalidad')->references('id')->on('municipalidades');
            $table->foreign('id_municipalidad_integrada')->references('id')->on('municipalidad_integradas');
  
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
        Schema::dropIfExists('mucipalidad_detalles');
    }
}
