<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamo_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_prestamo')->nullable();
            $table->bigInteger('id_periodo_delegado')->nullable();
            $table->string('numero_cuota',10)->nullable();
            $table->date('fecha_pago')->nullable();
            $table->double('prestamo_pagar',15,8)->nullable();
            
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_prestamo')->references('id')->on('prestamos');
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
        Schema::dropIfExists('prestamo_detalles');
    }
}
