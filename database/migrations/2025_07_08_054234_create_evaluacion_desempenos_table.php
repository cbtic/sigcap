<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionDesempenosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('evaluacion_desempenos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delegado_id')->constrained('evaluadores');
            $table->string('comision_tecnica');
            $table->string('periodo_evaluacion');
            $table->foreignId('evaluador_id')->constrained('users');
            $table->json('respuestas'); // Almacenará todas las respuestas en formato JSON
            $table->text('comentarios')->nullable();
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
        Schema::dropIfExists('evaluacion_desempenos');
    }
}
