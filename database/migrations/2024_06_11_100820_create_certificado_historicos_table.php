<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificadoHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificado_historicos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_agremiado')->nullable();
            $table->bigInteger('id_tipo')->nullable();
            $table->datetime('fecha')->nullable();
            $table->string('numero_certificado',20)->nullable();
            $table->string('propietario',100)->nullable();
            $table->string('nombre_proyecto',100)->nullable();
            $table->string('distrito',50)->nullable();
            $table->double('area_lote',10,2)->nullable();
            $table->double('area_construida',10,2)->nullable();
            $table->double('area_remodelada',10,2)->nullable();
            $table->string('tip_proyectista',50)->nullable();
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_agremiado')->references('id')->on('agremiados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificado_historicos');
    }
}
