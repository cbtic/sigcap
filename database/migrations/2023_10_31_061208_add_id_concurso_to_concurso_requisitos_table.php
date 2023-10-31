<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdConcursoToConcursoRequisitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concurso_requisitos', function (Blueprint $table) {
            $table->dropColumn('id_concurso_inscripcion');

            $table->bigInteger('id_concurso')->unsigned()->index();
            $table->foreign('id_concurso')->references('id')->on('concursos');
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
