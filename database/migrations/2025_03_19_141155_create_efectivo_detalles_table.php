<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEfectivoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('efectivo_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_efectivo')->unsigned()->index();
            $table->bigInteger('id_tipo_efectivo')->unsigned()->index();
            $table->string('cantidad')->nullable();
            $table->double('total',14,2)->nullable();
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
        Schema::dropIfExists('efectivo_detalles');
    }
}
