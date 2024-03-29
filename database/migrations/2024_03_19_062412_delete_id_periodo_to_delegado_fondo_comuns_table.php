<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIdPeriodoToDelegadoFondoComunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delegado_fondo_comuns', function (Blueprint $table) {
            $table->dropColumn('id_periodo_delegado');
            $table->dropColumn('id_periodo_delegado_detalle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delegado_fondo_comuns', function (Blueprint $table) {
            //
        });
    }
}
