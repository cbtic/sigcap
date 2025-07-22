<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasEncuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('respuesta_encuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregunta_id')->constrained('pregunta_encuestas')->cascadeOnDelete();
            $table->foreignId('expediente_id')->constrained('expedientes')->cascadeOnDelete();
            $table->foreignId('evaluador_id')->nullable()->constrained('evaluadores')->nullOnDelete();
            $table->text('respuesta'); // Almacena JSON para respuestas múltiples
            $table->timestamps();
            
            $table->index(['pregunta_id', 'expediente_id']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuestas_encuesta');
    }
}
