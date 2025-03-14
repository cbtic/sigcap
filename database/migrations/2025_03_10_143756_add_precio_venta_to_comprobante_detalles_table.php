<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrecioVentaToComprobanteDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_detalles', function (Blueprint $table) {
            $table->double('precio_venta',14,2)->nullable();
            $table->double('valor_venta_bruto',14,2)->nullable();
            $table->double('valor_venta',14,2)->nullable();
            $table->string('codigo',50)->nullable();
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
