<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFkToAsignacionCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asignacion_cuentas', function (Blueprint $table) {
            $table->dropForeign('asignacion_cuentas_id_centro_costo_foreign');
            $table->dropForeign('asignacion_cuentas_id_partida_presupuestal_foreign');
            $table->dropForeign('asignacion_cuentas_id_plan_contable_foreign');
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
