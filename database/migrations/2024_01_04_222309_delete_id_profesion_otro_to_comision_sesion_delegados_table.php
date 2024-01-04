<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIdProfesionOtroToComisionSesionDelegadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comision_sesion_delegados', function (Blueprint $table) {
            $table->dropColumn('id_profesion_otro');
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
