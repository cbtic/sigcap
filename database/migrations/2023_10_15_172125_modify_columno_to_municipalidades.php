<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnoToMunicipalidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('municipalidades', function (Blueprint $table) {
            //Modifica tipo de dato a Varcha(5)
            $table->string('id_tipo_municipalidad',5)->change();
            $table->string('id_tipo_comision',5)->change();
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
