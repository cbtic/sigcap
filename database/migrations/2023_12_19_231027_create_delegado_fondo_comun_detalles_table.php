<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegadoFondoComunDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegado_fondo_comun_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_delegado_fondo_comun')->nullable();
            $table->bigInteger('id_municipalidad')->nullable();
            $table->double('importe',15,8)->nullable();
            $table->string('mes_devengue',7)->nullable();
            $table->date('fecha_pago')->nullable();
            $table->Integer('item')->nullable(); 
            $table->string('credipago',14)->nullable();

            $table->string('estado',1)->nullable()->default('1'); 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_delegado_fondo_comun')->references('id')->on('delegado_fondo_comuns');
            $table->foreign('id_municipalidad')->references('id')->on('municipalidades');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delegado_fondo_comun_detalles');
    }
}
