<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanillaDelegadoDetalleTable extends Migration
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
            $table->bigInteger('id_planilla')->unsigned()->index();
            $table->bigInteger('id_delegado')->unsigned()->index();
            $table->bigInteger('sesiones')->unsigned()->index();
            $table->double('sub_total',16,2)->unsigned()->index();
            $table->bigInteger('id_concepto_planilla')->unsigned()->index();
            $table->double('monto',16,2)->unsigned()->index();

            $table->double('adelanto',16,2)->unsigned()->index();
            $table->double('reintegro',16,2)->unsigned()->index();
            $table->double('coordinador',16,2)->unsigned()->index();
            $table->double('total_bruto_sesiones',16,2)->unsigned()->index();
            $table->double('movilidad_sesion',16,2)->unsigned()->index();
            $table->double('movilidad_regular',16,2)->unsigned()->index();
            $table->double('total_movilidad',16,2)->unsigned()->index();
            $table->double('reintegro_asesor',16,2)->unsigned()->index();
            $table->double('total_bruto',16,2)->unsigned()->index();
            $table->double('ir_cuarta',16,2)->unsigned()->index();
            $table->double('total_honorario',16,2)->unsigned()->index();
            $table->double('descuento',16,2)->unsigned()->index();
            $table->double('saldo',16,2)->unsigned()->index();
                      
            $table->varchar('observaciones',5000)->unsigned()->index();
        

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
        Schema::dropIfExists('agremiado_otro_estudios');
    }
}
