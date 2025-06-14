<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observacion_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_solicitud')->nullable();
            $table->string('observacion',500)->nullable();

            $table->string('estado',1)->nullable()->default('1');
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
        Schema::dropIfExists('observacion_solicitudes');
    }
}
