<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcursoInscripcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concurso_inscripciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_agremiado')->unsigned()->index();
            $table->bigInteger('id_comprobante')->unsigned()->index();
            $table->bigInteger('id_concurso_puesto')->unsigned()->index();
            $table->string('puesto_postula',255)->nullable();
            $table->Integer('puntaje')->nullable();
            $table->string('resultado',100)->nullable();
            $table->string('puesto',255)->nullable();

            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_agremiado')->references('id')->on('agremiados');
            $table->foreign('id_concurso_puesto')->references('id')->on('concurso_puestos');
            $table->foreign('id_comprobante')->references('id')->on('comprobantes');

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
        Schema::dropIfExists('concurso_inscripciones');
    }
}
