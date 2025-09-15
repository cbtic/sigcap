<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegadoReintegroDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegado_reintegro_detalles', function (Blueprint $table) {
            $table->id();
                        
            $table->Integer('id_delegado_reintegro')->unsigned()->index();        
            $table->Integer('id_mes')->unsigned()->index();
            $table->bigInteger('id_tipo_reintegro')->nullable();  
            $table->Integer('cantidad')->nullable();
            $table->double('importe',15,8)->nullable();
                        
            $table->string('estado',1)->nullable()->default('1');
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_delegado_reintegro')->references('id')->on('delegado_reintegros');

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
        Schema::dropIfExists('delegado_reintegro_detalles');
    }
}
