<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoPlanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comisiones_sesiones_dictamenes', function (Blueprint $table) {
            $table->id(); 
            $table->integer('id_sesion')->nullable();           
            $table->string('ruta_dictamen',500)->nullable();
            $table->string('observaciones',5000)->nullable();
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_sesion')->references('id')->on('comisiones_sesiones');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comisiones_sesiones_dictamenes');
    }
}
