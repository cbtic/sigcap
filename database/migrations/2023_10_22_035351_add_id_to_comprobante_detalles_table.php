<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToComprobanteDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_detalles', function (Blueprint $table) {
            $table->bigInteger('id_comprobante')->unsigned()->index();
            $table->foreign('id_comprobante')->references('id')->on('comprobantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprobante_detalles', function (Blueprint $table) {
            //
        });
    }
}
