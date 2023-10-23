<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConceptoToProntoPagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pronto_pagos', function (Blueprint $table) {
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
        Schema::table('pronto_pagos', function (Blueprint $table) {
            //
        });
    }
}
