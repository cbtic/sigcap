<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdAgremiadoToComisionSesionDelegados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comision_sesion_delegados', function (Blueprint $table) {
            $table->integer('id_agremiado')->nullable()->unsigned()->index();            
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
        Schema::table('comision_sesion_delegados', function (Blueprint $table) {
            //
        });
    }
}
