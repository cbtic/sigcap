<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoRespuestaToPreguntaEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pregunta_encuestas', function (Blueprint $table) {
            //$table->enum('tipo_respuesta', ['radio', 'checkbox', 'text', 'select', 'numero', 'fecha', 'rango', 'si_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pregunta_encuestas', function (Blueprint $table) {
            //
        });
    }
}
