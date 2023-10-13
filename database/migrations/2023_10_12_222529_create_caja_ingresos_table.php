<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_ingresos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_regional')->unsigned()->index();
            $table->bigInteger('id_usuario')->unsigned()->index();
            $table->bigInteger('id_caja')->unsigned()->index();
            $table->double('saldo_inicial',15,8)->nullable();
            $table->double('total_recaudado',15,8)->nullable();
            $table->double('saldo_total',15,8)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->bigInteger('id_usuario_supervisor')->unsigned();
            $table->double('saldo_liquidado',15,8)->nullable();
            $table->string('observacion',400)->nullable();
            $table->bigInteger('id_moneda')->unsigned()->index()->nullable();
			$table->string('moneda',50)->nullable();
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
        Schema::dropIfExists('caja_ingresos');
    }
}
