<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->string('serie',10);
			$table->bigInteger('numero')->unsigned()->index();
			$table->string('tipo',2);
			$table->datetime('fecha')->nullable();
			$table->string('destinatario',100)->nullable();
			$table->string('direccion',200)->nullable();
			$table->string('cod_tributario',20)->nullable();
			$table->string('gia',50)->nullable();			
			$table->double('subtotal',15,8)->nullable();
			$table->double('impuesto',15,8)->nullable();
			$table->double('total',15,8)->nullable();
			
			$table->string('letras',200)->nullable();
			$table->bigInteger('id_moneda')->unsigned()->index()->nullable();
			$table->string('moneda',50)->nullable();
			$table->double('impuesto_factor',15,8)->nullable();
			$table->double('tipo_cambio',15,8)->nullable();
			$table->string('estado_pago',1)->nullable();
			$table->datetime('fecha_pago')->nullable();
			$table->datetime('fecha_recepcion')->nullable();
			$table->datetime('fecha_vencimiento')->nullable();
			$table->datetime('fecha_programado')->nullable();
			$table->bigInteger('id_forma_pago')->unsigned()->index()->nullable();
			$table->string('observacion',500)->nullable();
			$table->string('anulado',1)->nullable();
			$table->string('afecta',20)->nullable();
			$table->string('cerrado',1)->nullable();
			$table->bigInteger('id_tipo_documento')->unsigned()->index()->nullable();
			$table->string('eliminado',1)->nullable();
			$table->string('serie_ncnd',10)->nullable();
			$table->bigInteger('id_numero_ncnd')->unsigned()->index()->nullable();
			$table->string('tipo_ncnd',2)->nullable();
			$table->string('orden_compra',20)->nullable();
			$table->string('solictante',50)->nullable();
		
			$table->string('impreso',1)->nullable();
			$table->string('codtipo_ncnd',2)->nullable();
			$table->string('motivo_ncnd',250)->nullable();
			$table->double('total_grav',14,2)->nullable();
			$table->double('total_inaf',14,2)->nullable();
			$table->double('total_exo',14,2)->nullable();
			$table->double('total_descuentos',14,2)->nullable();
			$table->string('serie_guia',4)->nullable();
			$table->string('nro_guia',8)->nullable();
			$table->string('tipo_guia',2)->nullable();
			$table->string('serie_refer',4)->nullable();
			$table->string('nro_refer',8)->nullable();
			$table->string('tipo_refer',2)->nullable();
			$table->double('base_perce',14,2)->nullable();
			$table->double('monto_perce',14,2)->nullable();
			$table->double('totalconperce',14,2)->nullable();
			$table->double('ope_gratuitas',17,2)->nullable();
			$table->double('desc_globales',14,2)->nullable();
			$table->string('tipo_emision',10)->nullable();
			$table->string('correo_des',100)->nullable();
			$table->string('porc_detrac',18)->nullable();
			$table->double('monto_detrac',14,2)->nullable();
			$table->string('cuenta_detrac',15)->nullable();
			$table->double('total_anticipo',17,2)->nullable();
			$table->string('motivo_baja',100)->nullable();
			$table->string('tipo_operacion',3)->nullable();
			$table->string('estado_sunat',50)->nullable();
			$table->string('ruta_comprobante',4000)->nullable();
			$table->string('codigo_bbss_detrac',5)->nullable();
			$table->string('estado_email',50)->nullable();
			$table->datetime('fecha_anulacion')->nullable();
			$table->string('ticket_sunat',100)->nullable();
			$table->string('notas',200)->nullable();
			$table->string('cond_pago',100)->nullable();
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
        Schema::dropIfExists('comprobantes');
    }
}
