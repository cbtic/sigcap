<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFechaInscripcionToConcursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concursos', function (Blueprint $table) {
            $table->renameColumn('fecha_delegatura_inicio', 'fecha_acreditacion_inicio');
			$table->renameColumn('fecha_delegatura_fin', 'fecha_acreditacion_fin');
			$table->renameColumn('fecha_inscripcion', 'fecha_inscripcion_inicio');
			$table->datetime('fecha_inscripcion_fin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('concursos', function (Blueprint $table) {
            //
        });
    }
}
