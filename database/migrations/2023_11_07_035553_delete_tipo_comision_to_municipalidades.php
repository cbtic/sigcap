<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteTipoComisionToMunicipalidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('municipalidades', function (Blueprint $table) {
            $table->dropColumn('id_tipo_comision');
            $table->dropColumn('id_instancia_municipalidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('municipalidades', function (Blueprint $table) {
            //
        });
    }
}
