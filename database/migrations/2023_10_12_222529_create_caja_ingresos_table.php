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
            $table->bigInteger('id_usuario')->unsigned()->index();
            $table->bigInteger('id_caja')->unsigned()->index();
            $table->double('saldo_inicial',15,8)->nullable();
            $table->double('total_recaudado',15,8)->nullable();
            $table->double('saldo_total',15,8)->nullable();
            $table->date('voucher_fecha')->nullable();
            $table->date('voucher_fecha')->nullable();


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
