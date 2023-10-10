<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planillas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_tipo_planilla')->unsigned()->index();
            $table->bigInteger('id_periodo_delegado')->unsigned()->index();
            $table->string('aprobacion_contabilidad',1)->nullable()->default('1');
            $table->string('aprobacion_at',1)->nullable()->default('1');
            $table->string('aprobacion_tesoreria',1)->nullable()->default('1');

            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_tipo_planilla')->references('id')->on('tipo_planillas');
            $table->foreign('id_periodo_delegado')->references('id')->on('periodo_delegados');
 
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
        Schema::dropIfExists('planillas');
    }
}
