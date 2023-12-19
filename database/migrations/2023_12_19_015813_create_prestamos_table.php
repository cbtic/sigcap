<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_agremiado')->nullable();
            $table->bigInteger('id_periodo_delegado')->nullable();
            $table->bigInteger('id_tipo_prestamo')->nullable();
            $table->date('fecha')->nullable();
            $table->bigInteger('nro_total_cuotas')->nullable();
            $table->double('total_prestamo',15,8)->nullable();
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_agremiado')->references('id')->on('agremiados');
            $table->foreign('id_periodo_delegado')->references('id')->on('periodo_delegados');
          //  $table->foreign('id_tipo_prestamo')->references('id')->on('tabla_maestras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestamos');
    }
}
