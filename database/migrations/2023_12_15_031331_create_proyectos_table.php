<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ubigeo')->nullable();
            $table->bigInteger('id_tipo_sitio')->nullable();
            $table->bigInteger('id_tipo_direccion')->nullable();
            $table->string('nombre',150)->nullable();
            $table->string('lugar',150)->nullable();
            $table->string('manzana',10)->nullable();
            $table->string('parcela',10)->nullable();
            $table->string('super_manzana',10)->nullable();
            $table->string('direccion',100)->nullable();
            $table->integer('numero')->nullable();
            $table->integer('interior')->nullable();
            $table->integer('lote')->nullable();
            $table->integer('sub_lote')->nullable();
            $table->integer('fila')->nullable();
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_ubigeo')->references('id')->on('ubigeos');
            //$table->foreign('id_tipo_sitio')->references('id')->on('tabla_maestras');
            //$table->foreign('id_tipo_direccion')->references('id')->on('tabla_maestras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
}
