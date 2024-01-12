<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPeridoToConcursos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concursos', function (Blueprint $table) {
            $table->integer('id_periodo')->nullable()->unsigned()->index();            
            $table->foreign('id_periodo')->references('id')->on('periodo_comisiones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('concursos', function (Blueprint $table) {
            //
        });
    }
}
