<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdSolicitudToUsoEdificaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uso_edificaciones', function (Blueprint $table) {
            $table->bigInteger('id_solicitud')->nullable();
            $table->foreign('id_solicitud')->references('id')->on('solicitudes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uso_edificaciones', function (Blueprint $table) {
            //
        });
    }
}
