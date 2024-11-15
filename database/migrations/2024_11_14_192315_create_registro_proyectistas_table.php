<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroProyectistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_proyectistas', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('id_agremiado')->nullable()->unsigned()->index();
			$table->bigInteger('id_profesion_otro')->nullable()->unsigned()->index();
			$table->integer('id_profesion')->nullable();
			$table->string('ruta_firma',100)->nullable();
			$table->string('foto',100)->nullable();
			$table->string('estado',1)->nullable()->default('1');
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
        Schema::dropIfExists('registro_proyectistas');
    }
}
