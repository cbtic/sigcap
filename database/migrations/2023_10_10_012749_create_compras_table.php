<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_periodo_delegado')->unsigned()->index();
            $table->string('voucher_codigo',20)->nullable();
            $table->bigInteger('voucher_id_banco')->unsigned()->index();
            $table->datetime('voucher_fecha')->nullable();
            $table->bigInteger('id_empresa')->unsigned()->index();

            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_periodo_delegado')->references('id')->on('periodo_delegados');
            $table->foreign('id_empresa')->references('id')->on('empresas');
 
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
        Schema::dropIfExists('compras');
    }
}
