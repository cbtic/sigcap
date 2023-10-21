<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValorizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valorizaciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_modulo')->unsigned()->index();
            $table->bigInteger('id_concepto')->unsigned()->index();
            $table->bigInteger('id_agremido')->nullable();
            $table->bigInteger('id_empresa')->nullable();
            $table->bigInteger('id_comprobante')->nullable();
            $table->double('monto',17,2)->nullable();

            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_modulo')->references('id')->on('modulos');
            $table->foreign('id_concepto')->references('id')->on('conceptos');

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
        Schema::dropIfExists('valorizaciones');
    }
}
