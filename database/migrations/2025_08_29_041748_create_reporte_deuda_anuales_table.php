<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReporteDeudaAnualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporte_deuda_anuales', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_cierre')->nullable();
            $table->date('fecha_consulta')->nullable();
            $table->bigInteger('id_agremiado')->unsigned()->index();
            $table->string('numero_cap')->nullable();
            $table->string('apellidos_nombre')->nullable();
            $table->double('monto',14,2)->nullable();
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
        Schema::dropIfExists('reporte_deuda_anuales');
    }
}
