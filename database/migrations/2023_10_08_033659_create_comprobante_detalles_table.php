<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobanteDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_detalles', function (Blueprint $table) {
            $table->id();
            $table->string('serie',10);
			$table->bigInteger('numero')->unsigned()->index();
			$table->string('tipo',2);
			$table->bigInteger('item')->unsigned()->index();
			$table->string('descripcion',500)->nullable();
			$table->double('pu',15,8)->nullable();
			$table->double('importe',15,8)->nullable();
			$table->double('pu_con_igv',14,2)->nullable();			
			$table->double('igv_total',14,2)->nullable();
			$table->string('afect_igv',2)->nullable();
            $table->string('unidad',6)->nullable();
            $table->string('cod_contable',20)->nullable();
			$table->double('descuento',14,2)->nullable();
			$table->double('valor_gratu',14,2)->nullable();
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
        Schema::dropIfExists('comprobante_detalles');
    }
}
