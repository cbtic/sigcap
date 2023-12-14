<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipalidadDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipalidad_detalles', function (Blueprint $table) {
            $table->id(); 
            $table->integer('id_municipalidad_integrada')->nullable();    
            $table->integer('id_municipalidad')->nullable();       
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_municipalidad_integrada')->references('id')->on('municipalidad_integradas');
            $table->foreign('id_municipalidad')->references('id')->on('municipalidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipalidad_detalles');
    }
}
