<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdComisionSesionToComputoSesiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('computo_sesiones', function (Blueprint $table) {
            $table->bigInteger('id_comision_sesion')->nullable();
            $table->foreign('id_comision_sesion')->references('id')->on('comision_sesiones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('computo_sesiones', function (Blueprint $table) {
            //
        });
    }
}
