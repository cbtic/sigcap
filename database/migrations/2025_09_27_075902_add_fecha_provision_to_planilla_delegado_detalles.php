<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaProvisionToPlanillaDelegadoDetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planilla_delegado_detalles', function (Blueprint $table) {
            //
            $table->date('fecha_provision')->nullable();
            $table->date('fecha_provision_cancela')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planilla_delegado_detalles', function (Blueprint $table) {
            //
        });
    }
}
