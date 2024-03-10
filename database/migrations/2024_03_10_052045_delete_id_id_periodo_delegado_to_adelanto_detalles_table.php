<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIdIdPeriodoDelegadoToAdelantoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adelanto_detalles', function (Blueprint $table) {
            $table->dropColumn('id_periodo_delegado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adelanto_detalles', function (Blueprint $table) {
            //
        });
    }
}
