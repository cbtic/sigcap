<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanContablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_contables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_concepto')->unsigned()->index();
            $table->bigInteger('id_plantilla detalle')->unsigned()->index();
            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_concepto')->references('id')->on('conceptos');
 
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
        Schema::dropIfExists('plan_contables');
    }
}
