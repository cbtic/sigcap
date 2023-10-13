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

    id bigserial NOT NULL,
	id_usuario int8 NOT NULL,
	id_caja int8 NOT NULL,
	saldo_inicial float8 NULL,
	total_recaudado float8 NULL,
	saldo_total float8 NULL,
	fecha_inicio timestamp(0) NOT NULL,
	estado varchar(1) NULL,
	fecha_fin timestamp(0) NULL,
	id_usuario_contabilidad int4 NULL,
	saldo_liquidado float8 NULL,
	observacion varchar(255) NULL,
	id_moneda int8 NULL,
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
