<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeletePresupuestosToSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropColumn('id_presupuesto');
            $table->dropColumn('id_solicitud_documento');
            $table->dropColumn('id_uso_edificacion');
            $table->dropColumn('id_propietario');
            $table->dropColumn('id_solicitud_observacion');
            $table->dropColumn('id_proyectista');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            //
        });
    }
}
