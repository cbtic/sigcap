<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdelantoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adelanto_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_adelanto')->nullable();
            $table->bigInteger('id_periodo_delegado')->nullable();
            $table->bigInteger('numero_cuota')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->double('adelanto_pagar',15,8)->nullable();
            
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_adelento')->references('id')->on('adelantos');
            $table->foreign('id_periodo_delegado')->references('id')->on('periodo_delegados'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adelanto_detalles');
    }
}
