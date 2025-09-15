<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteCamposCharToConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conceptos', function (Blueprint $table) {
            $table->dropColumn('cuenta_contable_debe');
            $table->dropColumn('cuenta_contable_al_haber1');
            $table->dropColumn('cuenta_contable_al_haber2');
            $table->dropColumn('partida_presupuestal');
            $table->dropColumn('centro_costo');
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
