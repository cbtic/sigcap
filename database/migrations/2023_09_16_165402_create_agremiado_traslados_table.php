<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgremiadoTrasladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agremiado_traslados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_agremiado')->unsigned()->index();
            $table->bigInteger('id_region')->unsigned()->index();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('numero_regional')->nullable();
            $table->string('observacion',200)->nullable();            
            $table->string('estado',1)->nullable()->default('1');   

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_region')->references('id')->on('regiones');
            $table->foreign('id_agremiado')->references('id')->on('agremiados');


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
        Schema::dropIfExists('agremiado_traslados');
    }
}
