<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdGrupoSanguineoToPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->string('grupo_sanguineo',5)->nullable();
            $table->string('id_ubigeo_nacimiento',6)->nullable();
            $table->string('lugar_nacimiento',200)->nullable();
            $table->bigInteger('id_nacionalidad')->nullable();
            $table->string('numero_ruc',10)->nullable();
            $table->string('desc_cliente_Sunat',300)->nullable();
            $table->string('direccion_sunat',400)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personas', function (Blueprint $table) {
            //
        });
    }
}
