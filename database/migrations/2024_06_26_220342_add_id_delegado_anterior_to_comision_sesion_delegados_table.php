<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdDelegadoAnteriorToComisionSesionDelegadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comision_sesion_delegados', function (Blueprint $table) {
            $table->bigInteger('id_delegado_anterior')->nullable()->index();
			$table->bigInteger('id_agremiado_anterior')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comision_sesion_delegados', function (Blueprint $table) {
            //
        });
    }
}
