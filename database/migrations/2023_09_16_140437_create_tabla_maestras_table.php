<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablaMaestrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabla_maestras', function (Blueprint $table) {
            $table->id();
			$table->string('tipo',50)->nullable();
			$table->string('denominacion',100)->nullable();
			$table->string('codigo',3)->nullable();
			$table->string('tipo_nombre',100)->nullable();
			$table->bigInteger('orden')->unsigned()->index();
			$table->string('estado',1)->nullable();
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
        Schema::dropIfExists('tabla_maestras');
    }
}
