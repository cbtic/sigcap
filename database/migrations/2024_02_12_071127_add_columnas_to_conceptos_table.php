<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnasToConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conceptos', function (Blueprint $table) {
            $table->integer('cuenta_contable_debe')->nullable()->unsigned()->index(); 
            $table->integer('cuenta_contable_al_haber1')->nullable()->unsigned()->index(); 
            $table->integer('cuenta_contable_al_haber2')->nullable()->unsigned()->index(); 
            $table->integer('partida_presupuestal')->nullable()->unsigned()->index(); 
            $table->integer('centro_costo')->nullable()->unsigned()->index(); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conceptos', function (Blueprint $table) {
            //
        });
    }
}
