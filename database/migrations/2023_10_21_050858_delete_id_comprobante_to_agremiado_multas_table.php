<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIdComprobanteToAgremiadoMultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agremiado_multas', function (Blueprint $table) {
            $table->dropColumn('id_comprobante');
            $table->bigInteger('id_concepto')->unsigned()->index();
            $table->foreign('id_concepto')->references('id')->on('conceptos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agremiado_multas', function (Blueprint $table) {
            //
        });
    }
}
