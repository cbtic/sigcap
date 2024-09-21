<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdComisionAgremiadoToPlanillaDelegadoDetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planilla_delegado_detalles', function (Blueprint $table) {
			$table->integer('id_comision')->nullable()->unsigned()->index();
            $table->integer('id_agremiado')->nullable()->unsigned()->index();

            $table->foreign('id_comision')->references('id')->on('comisiones');
            $table->foreign('id_agremiado')->references('id')->on('agremiados');
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
