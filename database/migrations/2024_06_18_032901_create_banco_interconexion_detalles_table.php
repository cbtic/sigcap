<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancoInterconexionDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banco_interconexion_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('id_banco_interconexion')->nullable()->unsigned()->index();
            $table->string('codigoerrororiginal',255)->nullable();
            $table->string('descrespuesta',255)->nullable();
            $table->string('nombrecliente',255)->nullable();
            $table->string('nombreempresa',255)->nullable();
            $table->string('numoperacionerp',255)->nullable();
            $table->string('codigoproducto',255)->nullable();
            $table->string('descrproducto',255)->nullable();
            $table->string('numdocumento',255)->nullable();
            $table->string('descdocumento',255)->nullable();
            $table->string('fechavencimiento',255)->nullable();
            $table->string('fechaemision',255)->nullable();
            $table->string('deuda',255)->nullable();
            $table->string('mora',255)->nullable();
            $table->string('gastosadm',255)->nullable();
            $table->string('pagominimo',255)->nullable();
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

            $table->foreign('id_banco_interconexion')->references('id')->on('banco_interconexiones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banco_interconexion_detalles');
    }
}
