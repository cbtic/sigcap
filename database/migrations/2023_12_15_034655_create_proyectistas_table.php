<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectistas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_tipo_profesional')->nullable();
            $table->bigInteger('id_agremiado')->nullable();
            $table->string('celular',50)->nullable();
            $table->string('email',100)->nullable();
            $table->string('firma',50)->nullable();
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            //$table->foreign('id_tipo_profesional')->references('id')->on('tabla_maestras');
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
        Schema::dropIfExists('proyectistas');
    }
}
