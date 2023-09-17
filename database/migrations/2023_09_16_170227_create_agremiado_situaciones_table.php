<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgremiadoSituacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agremiado_situaciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_agremiado')->unsigned()->index();
            $table->bigInteger('id_motivo')->unsigned()->index();
            $table->bigInteger('id_pais_destino')->unsigned()->index();                        
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();            
            $table->string('ruta_documento',200)->nullable(); 
            $table->string('estado',1)->nullable()->default('1');   

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_agremiado')->references('id')->on('agremiados');
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
        Schema::dropIfExists('agremiado_situaciones');
    }
}
