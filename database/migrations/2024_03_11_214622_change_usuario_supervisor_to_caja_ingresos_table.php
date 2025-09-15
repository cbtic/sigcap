<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsuarioSupervisorToCajaIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caja_ingresos', function (Blueprint $table) {
            $table->renameColumn('id_usuario_supervisor', 'id_usuario_contabilidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('caja_ingresos', function (Blueprint $table) {
            //
        });
    }
}
