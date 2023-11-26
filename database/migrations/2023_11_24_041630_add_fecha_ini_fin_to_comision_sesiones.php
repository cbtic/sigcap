<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaIniFinToComisionSesiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comision_sesiones', function (Blueprint $table) {
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
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
