<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgremiadoMultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agremiado_multas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_multa')->unsigned()->index();
            $table->bigInteger('id_comprobante')->unsigned()->index();
            $table->date('fecha')->nullable();
            $table->double('monto',14,2)->nullable();
            $table->bigInteger('id_estado_pago')->unsigned()->index();
            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_multa')->references('id')->on('multas');
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
        Schema::dropIfExists('agremiado_multas');
    }
}
