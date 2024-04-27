<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegadoTributosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegado_tributos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_agremiado')->nullable();
            $table->bigInteger('id_tipo_tributo')->nullable();
            $table->bigInteger('id_tipo_operacion')->nullable();
            $table->bigInteger('id_banco')->nullable();
            $table->string('numero_cuenta',25)->nullable();
            $table->string('cci',25)->nullable();
            $table->double('monto_minimo',17,2)->nullable();
            $table->date('fecha_solicitud')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_agremiado')->references('id')->on('agremiados');

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
        Schema::dropIfExists('delegado_tributos');
    }
}
