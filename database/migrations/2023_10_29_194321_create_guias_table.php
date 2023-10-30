<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guias', function (Blueprint $table) {
            $table->id();
			$table->string('guia_serie',10);
            $table->bigInteger('guia_numero')->unsigned()->index();
            $table->string('guia_tipo',2);
            $table->date('guia_fecha_emision')->nullable();
            $table->string('guia_serie_relacionado',4)->nullable();
            $table->string('guia_num_relacionado',8)->nullable();
            $table->string('guia_tipo_relacionado',2)->nullable();
            $table->string('guia_serie_baja',4)->nullable();
            $table->string('guia_num_baja',8)->nullable();
            $table->string('guia_tipo_baja',2)->nullable();
            $table->string('guia_emisor_numdoc',11)->nullable();
            $table->string('guia_emisor_tipodoc',1)->nullable();
            $table->string('guia_emisor_razsocial',100)->nullable();
            $table->string('guia_receptor_numdoc',15)->nullable();
            $table->string('guia_receptor_tipodoc',1)->nullable();
            $table->string('guia_receptor_razsocial',100)->nullable();
            $table->string('guia_tercero_numdoc',15)->nullable();
            $table->string('guia_tercero_tipodoc',1)->nullable();
            $table->string('guia_tercero_razsocial',100)->nullable();
            $table->string('guia_cod_motivo',2)->nullable();
            $table->text('guia_desc_motivo')->nullable();
            $table->string('guia_transbordo',1)->nullable();
            $table->double('guia_peso_bruto',15,8)->nullable();
            $table->string('guia_bultos',11)->nullable();
            $table->string('guia_modo_traslado',2)->nullable();
            $table->date('guia_fecha_traslado')->nullable();
            $table->string('guia_transportista_numdoc',15)->nullable();
            $table->string('guia_transportista_tipo_doc',1)->nullable();
            $table->string('guia_transportista_razsoc',100)->nullable();
            $table->string('guia_vehiculo_placa',8)->nullable();
            $table->string('guia_conductor_numdoc',11)->nullable();
            $table->string('guia_conductor_tipodoc',2)->nullable();
            $table->string('guia_llegada_ubigeo',9)->nullable();
            $table->string('guia_llegada_direccion',100)->nullable();
            $table->string('guia_partida_ubigeo',9)->nullable();
            $table->string('guia_partida_direccion',100)->nullable();
            $table->string('guia_numero_contenedor',17)->nullable();
            $table->string('guia_puerto_desembarque',3)->nullable();
            $table->string('guia_observaciones',250)->nullable();
            $table->string('guia_ruta_comprobante',400)->nullable();
            $table->string('guia_email',100)->nullable();
            $table->string('guia_estado_email',20)->nullable();
            $table->string('guia_estado_sunat',50)->nullable();
            $table->string('guia_anulado',1)->nullable();
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
        Schema::dropIfExists('guias');
    }
}
