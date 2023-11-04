<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->datetime('fecha_solicitud')->nullable(); 
            $table->datetime('fecha_emision')->nullable(); 
            $table->Integer('id_agremiado',1)->nullable()->default('0');  
            $table->Integer('tipo_certificado')->unsigned()->index();
            $table->integer('dias_validez',300)->nullable();
            $table->string('especie_valorada',20)->nullable();
            $table->string('codigo',20)->nullable();             
            $table->string('observaciones',400)->nullable();             
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodo_comisiones');
    }
}
