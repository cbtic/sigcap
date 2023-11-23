<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionSesionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_sesiones', function (Blueprint $table) {
            $table->id(); 
            $table->integer('id_regional')->nullable();           
            $table->integer('id_periodo_comisione')->nullable();
            $table->integer('id_tipo_sesion')->nullable();
            $table->date('fecha_programado')->nullable();
            $table->date('fecha_ejecucion')->nullable();
            $table->date('hora_inicio')->nullable();
            $table->date('hora_fin')->nullable();
            $table->integer('id_aprobado')->nullable();
            $table->string('observaciones',5000)->nullable();
            $table->integer('id_comision')->nullable();
            $table->integer('id_estado_sesion')->nullable();

            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_regional')->references('id')->on('regiones');
            $table->foreign('id_periodo_comisione')->references('id')->on('periodo_comisiones');
            $table->foreign('id_comision')->references('id')->on('comisiones');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comision_sesiones');
    }
}
