<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionMovilidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_movilidades', function (Blueprint $table) {
            $table->id();
            $table->integer('id_municipalidad_integrada');
            $table->integer('id_periodo_comisiones');
            $table->integer('id_regional');
            $table->double('monto',17,2);
            
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_municipalidad_integrada')->references('id')->on('municipalidad_integradas');
            $table->foreign('periodo_comisiones')->references('id')->on('periodo_comisiones');

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
        Schema::dropIfExists('comision_movilidades');
    }
}
