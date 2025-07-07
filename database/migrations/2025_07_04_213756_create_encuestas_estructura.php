<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestasEstructura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuestas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->boolean('activa')->default(true);

            $table->string('estado',1)->nullable()->default('1');  
            $table->timestamps();
        });

        Schema::create('seccion_encuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encuesta_id')->constrained();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->integer('orden')->default(0);

            $table->string('estado',1)->nullable()->default('1');          
            $table->timestamps();
        });

        Schema::create('pregunta_encuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seccion_id')->constrained('seccion_encuestas');
            $table->text('pregunta');
            $table->enum('tipo_respuesta', ['radio', 'checkbox', 'text', 'select', 'numero', 'fecha', 'rango']);
            $table->boolean('requerida')->default(false);
            $table->integer('orden')->default(0);
            $table->json('opciones')->nullable();

            $table->string('estado',1)->nullable()->default('1');       
            $table->timestamps();
        });
/*
        Schema::create('respuesta_encuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregunta_id')->constrained('pregunta_encuestas');
            $table->foreignId('expediente_id')->constrained('expedientes');
            $table->text('respuesta');

            $table->string('estado',1)->nullable()->default('1');         
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encuestas');
    }
}
