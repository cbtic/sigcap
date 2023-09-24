<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgremiadoTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agremiado_trabajos', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('id_agremiado')->unsigned()->index();
            $table->bigInteger('id_persona')->unsigned()->index();
            
            $table->string('modalidad',1)->nullable()->default('1');
            $table->string('numero_documento',15)->nullable();
            $table->string('razon_social',200)->nullable();
            $table->Integer('id_cliente_cargo')->unsigned()->index();
            $table->string('rubro_negocio',200)->nullable();
            $table->string('id_ubigeo',6)->nullable();
            $table->string('direccion',200)->nullable();
            $table->string('referencia',200)->nullable();
            $table->string('codigo_postal',20)->nullable();
            $table->string('telefono',20)->nullable();           
            $table->string('celular',20)->nullable();            
            $table->string('email',100)->nullable();  

            $table->string('estado',1)->nullable()->default('1');
            
			$table->foreign('id_persona')->references('id')->on('personas');
            $table->foreign('id_agremiado')->references('id')->on('agremiados');

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
        Schema::dropIfExists('agremiado_trabajos');
    }
}
