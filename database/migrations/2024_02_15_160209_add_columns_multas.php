<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsMultas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('multas', function (Blueprint $table) {
            $table->varchar('id_concepto',10)->nullable()->index(); 
            
            $table->foreign('id_concepto')->references('codigo')->on('conceptos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multas', function (Blueprint $table) {
            //
        });
    }
}
