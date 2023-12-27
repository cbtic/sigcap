<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanillaDelegadosTable extends Migration
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
            $table->bigInteger('periodo')->nullable();
            $table->bigInteger('mes')->nullable();
            $table->bigInteger('id_usuario_tecnica')->nullable();
            $table->bigInteger('id_usuario_contable')->nullable();
            $table->bigInteger('id_situacion')->nullable();
            $table->string('estado',1)->nullable()->default('1');
        
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            $table->timestamps();

            $table->foreign('id_regional')->references('id')->on('regiones');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planilla_delegados');
    }
}
