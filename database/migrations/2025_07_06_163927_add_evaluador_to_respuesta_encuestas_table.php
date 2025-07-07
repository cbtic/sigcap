<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEvaluadorToRespuestaEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('respuesta_encuestas', function (Blueprint $table) {
            $table->foreignId('encuesta_id')->constrained();
            $table->string('seccion');
            $table->string('pregunta');
            //$table->text('respuesta');
            //$table->foreignId('evaluador_id')->nullable()->constrained('evaluadores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('respuesta_encuestas', function (Blueprint $table) {
            //
        });
    }
}
