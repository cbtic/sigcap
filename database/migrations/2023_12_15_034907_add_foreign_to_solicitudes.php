<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToSolicitudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
           
           
            $table->foreign('id_proyectista')->references('id')->on('proyectistas');
            $table->foreign('id_propietario')->references('id')->on('propietarios');
            $table->foreign('id_presupuesto')->references('id')->on('presupuestos');
            $table->foreign('id_uso_edificacion')->references('id')->on('uso_edificaciones');
            $table->foreign('id_solicitud_documento')->references('id')->on('solicitud_documentos');
            $table->foreign('id_proyecto')->references('id')->on('proyectos');
            $table->foreign('id_usuario_revisa')->references('id')->on('users');
            $table->foreign('id_usuario_aprueba')->references('id')->on('users');
            $table->foreign('id_solicitud_observacion')->references('id')->on('solicitud_observaciones');
            //$table->foreign('id_resultado')->references('id')->on('resultados');
            $table->foreign('id_liquidacion')->references('id')->on('liquidaciones');
            //$table->foreign('id_comision_proyecto')->references('id')->on('comision_proyectos');
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
