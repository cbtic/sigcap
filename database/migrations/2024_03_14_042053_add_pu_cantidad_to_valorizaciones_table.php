<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPuCantidadToValorizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('valorizaciones', function (Blueprint $table) {
            $table->double('valor_unitario',17,2)->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('otro_concepto',1)->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('valorizaciones', function (Blueprint $table) {
            //
        });
    }
}
