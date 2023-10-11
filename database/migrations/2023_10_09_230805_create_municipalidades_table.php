<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipalidades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_regional')->unsigned()->index();
            $table->string('denominacion',150)->nullable();
            $table->bigInteger('id_tipo_municipalidad')->unsigned()->index();
            $table->bigInteger('id_tipo_comision')->unsigned()->index();
            $table->bigInteger('id_instancia_municipalidad')->unsigned()->index();
            $table->bigInteger('id_ubigeo')->unsigned()->index();
            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_regional')->references('id')->on('regiones');
            $table->foreign('id_ubigeo')->references('id')->on('ubigeos');
  
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
        Schema::dropIfExists('municipalidades');
    }
}
