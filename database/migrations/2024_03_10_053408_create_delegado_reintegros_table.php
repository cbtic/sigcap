<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegadoReintegrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegado_reintegros', function (Blueprint $table) {
            $table->id();
                        
            $table->Integer('id_regional')->unsigned()->index();
            $table->bigInteger('id_periodo')->nullable();
            $table->Integer('id_mes')->unsigned()->index();
            $table->bigInteger('id_delegado')->nullable();  
            $table->double('importe',15,8)->nullable();
            $table->string('observacion',250)->nullable();
            
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_regional')->references('id')->on('regiones');

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
        Schema::dropIfExists('delegado_reintegros');
    }
}
