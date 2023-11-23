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
        Schema::create('profesionaes_otros', function (Blueprint $table) {
            $table->id();            
            $table->string('colegiatura',100)->nullable();
            $table->string('colegiatura_abreviatura',20)->nullable();
            $table->integer('id_persona')->nullable();
            $table->integer('id_profesion')->nullable();
            $table->string('ruta_firma',500)->nullable();
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_profesion')->references('id')->on('profesiones');
            $table->foreign('id_persona')->references('id')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profesiones');
    }
}
