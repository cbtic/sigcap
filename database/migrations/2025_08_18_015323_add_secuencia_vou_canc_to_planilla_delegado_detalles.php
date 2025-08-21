<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecuenciaVouCancToPlanillaDelegadoDetalles extends Migration
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
              $table->integer('secuencua_vou_canc')->nullable();
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
