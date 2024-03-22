<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsientoPlanillaDelegadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asiento_planilla_delegados', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_moneda')->nullable();
            $table->bigInteger('numero')->nullable();
            $table->string('detraccion',50)->nullable();
            $table->string('retencion',50)->nullable();
            $table->string('percepcion',50)->nullable();
            $table->string('serie',50)->nullable();
            $table->bigInteger('id_cliente')->nullable();
            $table->datetime('fecha_documento',50)->nullable();
            $table->bigInteger('id_producto',50)->nullable();
            $table->string('nombre_producto',50)->nullable();
            $table->string('cta_ventas',50)->nullable();
            $table->string('tipo_cambio',50)->nullable();
            $table->bigInteger('id_tipo_documento',50)->nullable();
            $table->string('total',50)->nullable();
            $table->string('igv',50)->nullable();
            $table->string('sub_total',50)->nullable();
            $table->string('id_venta',50)->nullable();
            $table->datetime('fecha_vto',50)->nullable();
            $table->string('estado',50)->nullable();
            $table->string('doc_modifica',50)->nullable();
            $table->string('doc_modifica_tipo',50)->nullable();
            $table->string('sector',50)->nullable();
            $table->string('control_presupuestal',50)->nullable();
            $table->string('exonerado',50)->nullable();
            $table->string('inafecta',50)->nullable();
            $table->string('tipo_pago',50)->nullable();
            $table->string('detraccion',50)->nullable();
            $table->string('inafectad ',50)->nullable();

            $table->string('estado',1)->nullable()->default('1');

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
        Schema::dropIfExists('asiento_planilla_delegados');
    }
}
