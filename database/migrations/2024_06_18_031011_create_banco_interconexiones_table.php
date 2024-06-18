<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancoInterconexionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banco_interconexiones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_conexion',10)->nullable();
            $table->string('message_type_identification',255)->nullable();
            $table->string('primary_bit_map',255)->nullable();
            $table->string('secondary_bit_map',255)->nullable();
            $table->string('primary_account_number',255)->nullable();
            $table->string('processing_code',255)->nullable();
            $table->string('amount_transaction',255)->nullable();
            $table->string('trace',255)->nullable();
            $table->string('time_local_transaction',255)->nullable();
            $table->string('date_local_transaction',255)->nullable();
            $table->string('pos_entry_mode',255)->nullable();
            $table->string('pos_condition_code',255)->nullable();
            $table->string('acquirer_institution_id_code',255)->nullable();
            $table->string('forward_institution_id_code',255)->nullable();
            $table->string('retrieval_reference_number',255)->nullable();
            $table->string('card_acceptor_terminal_id',255)->nullable();
            $table->string('card_acceptor_id_code',255)->nullable();
            $table->string('card_acceptor_name_location',255)->nullable();
            $table->string('transaction_currency_code',255)->nullable();
            $table->string('longitud',255)->nullable();
            $table->string('codigoempresa',255)->nullable();
            $table->string('codigoproducto',255)->nullable();
            $table->string('tipoconsulta',255)->nullable();
            $table->string('numconsulta',255)->nullable();
            $table->string('numpagina',255)->nullable();
            $table->string('nummaxdocs',255)->nullable();
            $table->string('formapago',255)->nullable();
            $table->string('numreferenciaoriginal',255)->nullable();
            $table->string('numdocs',255)->nullable();
            $table->string('numdocumento',255)->nullable();
            $table->string('fechavencimiento',255)->nullable();
            $table->string('fechaemision',255)->nullable();
            $table->string('deuda',255)->nullable();
            $table->string('mora',255)->nullable();
            $table->string('gastosadm',255)->nullable();
            $table->string('importetotal',255)->nullable();
            $table->string('periodo',255)->nullable();
            $table->string('anio',255)->nullable();
            $table->string('cuota',255)->nullable();
            $table->string('monedadoc',255)->nullable();
            $table->string('filler',255)->nullable();
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
        Schema::dropIfExists('banco_interconexiones');
    }
}
