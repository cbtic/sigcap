<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_regional')->nullable();    
            $table->datetime('fecha_registro')->nullable();    
            $table->bigInteger('id_tipo_solicitud')->nullable(); 
            $table->bigInteger('id_tipo_tramite')->nullable();
            $table->bigInteger('id_municipalidad_integrada')->nullable();
            $table->integer('numero_revision')->nullable();
            $table->integer('nombre_proyecto')->nullable();
            $table->string('direccion',200)->nullable();
            $table->string('id_ubigeo',6)->nullable();
            $table->bigInteger('id_proyectista')->nullable();
            $table->bigInteger('id_propietario')->nullable();
            $table->integer('tipo_proyecto')->nullable();
            $table->integer('numero_sotano')->nullable();
            $table->integer('azotea')->nullable();
            $table->integer('semisotano')->nullable();
            $table->integer('numero_piso')->nullable();
            $table->double('valor_unitario',14,2)->nullable();
            $table->double('valor_obra',14,2)->nullable();
            $table->bigInteger('id_presupuesto')->nullable();
            $table->bigInteger('id_uso_edificacion')->nullable();
            $table->double('area_total',14,2)->nullable();
            $table->bigInteger('id_solicitud_documento')->nullable();
            $table->bigInteger('id_proyecto')->nullable();
            $table->bigInteger('id_usuario_revisa')->nullable();
            $table->datetime('fecha_revisado')->nullable();
            $table->bigInteger('id_usuario_aprueba')->nullable();
            $table->datetime('fecha_aprobado')->nullable();
            $table->bigInteger('id_solicitud_observacion')->nullable();
            $table->bigInteger('id_resultado')->nullable();
            $table->bigInteger('id_liquidacion')->nullable();
            $table->string('numero_expediente_municipal',25)->nullable();
            $table->bigInteger('id_comision_proyecto')->nullable();
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_regional')->references('id')->on('regiones');
            $table->foreign('id_tipo_solicitud')->references('id')->on('tabla_maestras');
            //$table->foreign('id_tipo_tramite')->references('id')->on('agremiados');
            $table->foreign('id_municipalidad_integrada')->references('id')->on('municipalidad_integradas');
            //$table->foreign('id_ubigeo')->references('id')->on('ubigeos');
            //$table->foreign('id_proyectista')->references('id')->on('proyectistas');
            //$table->foreign('id_propietario')->references('id')->on('propietarios');
            //$table->foreign('id_presupuesto')->references('id')->on('presupuestos');
            //$table->foreign('id_uso_edificacion')->references('id')->on('uso_edificacion');
            //$table->foreign('id_solicitud_documento')->references('id')->on('solicitud_documento');
            //$table->foreign('id_proyecto')->references('id')->on('proyectos');
            //$table->foreign('id_usuario_revisa')->references('id')->on('usuario_revisa');
            //$table->foreign('id_usuario_aprueba')->references('id')->on('usuario_aprueba');
            //$table->foreign('id_solicitud_observacion')->references('id')->on('solicitud_observacion');
            //$table->foreign('id_resultado')->references('id')->on('resultados');
            //$table->foreign('id_liquidacion')->references('id')->on('liquidacion');
            //$table->foreign('id_comision_proyecto')->references('id')->on('comision_proyecto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
