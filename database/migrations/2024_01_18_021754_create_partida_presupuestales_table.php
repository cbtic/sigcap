<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidaPresupuestalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partida_presupuestales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_regional')->unsigned()->index();
            $table->bigInteger('id_centro_costo')->nullable()->unsigned()->index();
            $table->string('periodo',8)->nullable();
            $table->string('codigo',8)->nullable();
            $table->string('denominacion',150)->nullable();                        
            $table->double('total_debe',15,8)->nullable();
            $table->double('total_haber',15,8)->nullable();
            $table->string('orden',8)->nullable();
            $table->string('estado',1)->nullable()->default('1');

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
        Schema::dropIfExists('partida_presupuestales');
    }
}
