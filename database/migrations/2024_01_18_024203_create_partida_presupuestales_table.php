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
            $table->double('total_01',15,8)->nullable();
            $table->double('total_02',15,8)->nullable();
            $table->double('total_03',15,8)->nullable();
            $table->double('total_04',15,8)->nullable();
            $table->double('total_05',15,8)->nullable();
            $table->double('total_06',15,8)->nullable();
            $table->double('total_07',15,8)->nullable();
            $table->double('total_08',15,8)->nullable();
            $table->double('total_09',15,8)->nullable();
            $table->double('total_10',15,8)->nullable();
            $table->double('total_11',15,8)->nullable();
            $table->double('total_12',15,8)->nullable();
            
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
