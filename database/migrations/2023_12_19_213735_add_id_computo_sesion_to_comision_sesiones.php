<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdComputoSesionToComisionSesiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comision_sesiones', function (Blueprint $table) {
            $table->bigInteger('id_computo_sesion')->nullable();
            $table->foreign('id_computo_sesion')->references('id')->on('computo_sesiones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comision_sesiones', function (Blueprint $table) {
            //
        });
    }
}
