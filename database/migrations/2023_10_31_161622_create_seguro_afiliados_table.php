<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguroAfiliadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguro_afiliados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_regional')->unsigned()->index();
            $table->bigInteger('id_plan')->unsigned()->index();
            $table->bigInteger('id_agremiado')->unsigned()->index();

            $table->date('fecha')->unsigned()->index();
            $table->string('observaciones')->unsigned()->index();
            
            
            $table->string('estado',1)->nullable()->default('1');
            
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            $table->timestamps();

            $table->foreign('id_plan')->references('id')->on('seguros_planes');
            $table->foreign('id_agremiado')->references('id')->on('agremiados');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguro_afiliados');
    }
}
