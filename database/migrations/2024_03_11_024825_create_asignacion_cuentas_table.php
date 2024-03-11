<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignacion_cuentas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_plan_contable')->nullable();
            $table->string('denominacion',250)->nullable();
            $table->bigInteger('id_tipo_cuenta')->nullable();
            $table->bigInteger('id_centro_costo')->nullable();
            $table->bigInteger('id_partida_presupuestal')->nullable(); 

            $table->bigInteger('id_codigo_financiamiento')->nullable(); //*
            $table->bigInteger('id_medio_pago')->nullable();
            $table->bigInteger('id_origen')->nullable(); //*
        
            $table->string('estado',1)->nullable()->default('1');
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            $table->timestamps();

            $table->foreign('id_plan_contable')->references('id')->on('plan_contables');
            $table->foreign('id_centro_costo')->references('id')->on('centro_costos');
            $table->foreign('id_partida_presupuestal')->references('id')->on('partida_presupuestales');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignacion_cuentas');
    }
}
