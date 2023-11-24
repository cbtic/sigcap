<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFechaIniFinToComisionSesionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comision_sesiones', function (Blueprint $table) {
            $table->dropColumn('hora_inicio');
            $table->dropColumn('hora_fin');
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
