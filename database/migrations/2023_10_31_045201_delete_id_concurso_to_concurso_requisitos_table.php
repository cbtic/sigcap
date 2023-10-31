<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIdConcursoToConcursoRequisitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concurso_requisitos', function (Blueprint $table) {
            $table->dropColumn('id_concurso');

            $table->bigInteger('id_concurso_inscripcion')->unsigned()->index();
            $table->foreign('id_concurso_inscripcion')->references('id')->on('concurso_inscripciones');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('concurso_requisitos', function (Blueprint $table) {
            //
        });
    }
}
