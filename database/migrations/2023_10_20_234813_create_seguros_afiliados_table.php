<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegurosAfiliadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguros_afiliados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_plan')->unsigned()->index();
            $table->bigInteger('id_agremiado')->unsigned()->index();
            $table->bigInteger('id_familia')->unsigned()->index();
            
            $table->string('estado',1)->nullable()->default('1');
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            $table->timestamps();

            $table->foreign('id_plan')->references('id')->on('seguros_planes');
            $table->foreign('id_agremiado')->references('id')->on('agremiados');
            $table->foreign('id_familia')->references('id')->on('agremiado_parentecos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguros_afiliados');
    }
}
