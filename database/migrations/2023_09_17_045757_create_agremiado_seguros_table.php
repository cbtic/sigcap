<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgremiadoSegurosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agremiado_seguros', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('id_persona')->unsigned()->index();
            $table->bigInteger('id_parentesco')->unsigned()->index();
            $table->bigInteger('id_region')->unsigned()->index();
            $table->bigInteger('id_agremiado')->unsigned()->index();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('estado',1)->nullable()->default('1');
            
			$table->foreign('id_persona')->references('id')->on('personas');
            $table->foreign('id_region')->references('id')->on('regiones');
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
        Schema::dropIfExists('agremiado_seguros');
    }
}
