<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanillaDelegadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planilla_delegados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_regional')->unsigned()->index();
            $table->bigInteger('periodo')->unsigned()->index();
            $table->bigInteger('mes')->unsigned()->index();
            $table->bigInteger('id_usuario_tecnica',1)->nullable();
            $table->bigInteger('id_usuario_contable',1)->nullable();
            $table->bigInteger('id_situacion')->nullable()->default('1');
        

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
        Schema::dropIfExists('agremiado_otro_estudios');
    }
}
