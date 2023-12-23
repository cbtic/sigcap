<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemsToComisionSesionDictamenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comision_sesion_dictamenes', function (Blueprint $table) {
            $table->bigInteger('unidad_inmobiliaria')->nullable();
            $table->string('numero_expediente',100)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->bigInteger('pisos')->nullable();
            $table->double('altura')->nullable();
            $table->double('area')->nullable();
            $table->bigInteger('id_numero_revision')->nullable();
            $table->bigInteger('id_apela_recon')->nullable();
            $table->string('opinion_presidente',1)->nullable();
            $table->string('opinion_presidente_desc',5000)->nullable();
            $table->string('opinion_delegado',1)->nullable();
            $table->Integer('id_opinion_delegado')->nullable();
            $table->Integer('id_instancia')->nullable();
            $table->string('opinion_delegado_desc',5000)->nullable();
            $table->string('notas_adicionales',5000)->nullable();
            $table->bigInteger('id_dictamen')->nullable();

          //  id_comision_sesion int4 NULL,
           // ruta_dictamen varchar(500) NULL,
           // observaciones varchar(5000) NULL,
                });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comision_sesion_dictamenes', function (Blueprint $table) {



        });
    }
}
