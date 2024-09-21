<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanillaDelegadoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planilla_delegado_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_planilla')->nullable();
            $table->bigInteger('id_comision_delegado')->nullable();
            $table->bigInteger('sesiones')->nullable();
            $table->double('sub_total',16,2)->nullable();
            $table->bigInteger('id_concepto_planilla')->nullable();
            $table->double('monto',16,2)->nullable();

            $table->double('adelanto',16,2)->nullable();
            $table->double('reintegro',16,2)->nullable();
            $table->double('coordinador',16,2)->nullable();
            $table->double('total_bruto_sesiones',16,2)->nullable();
            $table->double('movilidad_sesion',16,2)->nullable();
            $table->double('movilidad_regular',16,2)->nullable();
            $table->double('total_movilidad',16,2)->nullable();
            $table->double('reintegro_asesor',16,2)->nullable();
            $table->double('total_bruto',16,2)->nullable();
            $table->double('ir_cuarta',16,2)->nullable();
            $table->double('total_honorario',16,2)->nullable();
            $table->double('descuento',16,2)->nullable();
            $table->double('saldo',16,2)->nullable();
                      
            $table->string('observaciones',5000)->nullable();
            $table->string('estado',1)->nullable()->default('1');
        

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            $table->timestamps();

            $table->foreign('id_planilla')->references('id')->on('planilla_delegados');
            $table->foreign('id_comision_delegado')->references('id')->on('comision_delegados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planilla_delegado_detalles');
    }
}
