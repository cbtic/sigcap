<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdCodigoFinanciamientoToAsignacionCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asignacion_cuentas', function (Blueprint $table) {
            $table->renameColumn('id_codigo_financiamiento', 'id_codigo_financiero');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asignacion_cuentas', function (Blueprint $table) {
            //
        });
    }
}
