<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgremiadoEstudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agremiado_estudios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_agremiado')->unsigned()->index();
            $table->bigInteger('id_universidad')->unsigned()->index();
            $table->bigInteger('id_especialidad')->unsigned()->index();
            $table->string('estado',1)->nullable()->default('1');

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
        Schema::dropIfExists('agremiado_estudios');
    }
}
