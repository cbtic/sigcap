<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegadoFondoComunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegado_fondo_comuns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_periodo_delegado')->nullable();
            $table->bigInteger('id_periodo_delegado_detalle')->nullable();
            $table->double('porcentaje_igv',15,8)->nullable();
            $table->double('porcentaje_comision_cap',15,8)->nullable();
            $table->double('porcentaje_fondo_asistencia',15,8)->nullable();
            $table->double('porcentaje_reserva_acuerdo_n5',15,8)->nullable();
            $table->double('importe_bruto',15,8)->nullable();
            $table->double('importe_igv',15,8)->nullable();
            $table->double('importe_comision_cap',15,8)->nullable();
            $table->double('importe_fondo_asistencia',15,8)->nullable();
            $table->double('importe_reserva',15,8)->nullable();
            $table->double('saldo',15,8)->nullable();
            
            $table->string('estado',1)->nullable()->default('1'); 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

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
        Schema::dropIfExists('delegado_fondo_comuns');
    }
}
