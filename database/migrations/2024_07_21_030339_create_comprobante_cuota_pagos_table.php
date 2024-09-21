<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobanteCuotaPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_cuota_pagos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_comprobante')->unsigned()->index();
            $table->integer('item')->nullable();
            $table->date('fecha')->nullable();
            $table->integer('id_medio')->nullable();
            $table->string('nro_operacion',250)->nullable();
            $table->string('descripcion',250)->nullable();                        
            $table->double('monto',17,2)->nullable();
            $table->date('fecha_vencimiento')->nullable();
            
            $table->string('estado',1)->nullable()->default('1');


            $table->foreign('id_comprobante')->references('id')->on('comprobantes');
            
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
        Schema::dropIfExists('comprobante_cuota_pagos');
    }
}
