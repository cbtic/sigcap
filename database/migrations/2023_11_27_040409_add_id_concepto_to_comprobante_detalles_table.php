<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdConceptoToComprobanteDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_detalles', function (Blueprint $table) {
            $table->bigInteger('id_concepto')->unsigned()->index()->nullable();
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
