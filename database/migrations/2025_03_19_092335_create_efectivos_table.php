<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEfectivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('efectivos', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('id_caja')->unsigned()->index();
            $table->date('fecha')->nullable();
            $table->double('importe_soles',14,2)->nullable();
            $table->double('importe_dolares',14,2)->nullable();
            $table->bigInteger('id_moneda')->unsigned()->index();
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
        Schema::dropIfExists('efectivos');
    }
}
