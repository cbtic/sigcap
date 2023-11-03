<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegurosPlanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguros_planes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_seguro')->unsigned()->index();
            $table->string('nombre',255)->unsigned()->index();
            $table->string('descripcion',255)->unsigned()->index();
            $table->string('estado',1)->nullable()->default('1');
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            $table->date('fecha_inicio')->nullable()->unsigned()->index();
            $table->date('fecha_fin')->nullable()->unsigned()->index();
            $table->float('monto')->nullable()->unsigned()->index();
            $table->timestamps();
            $table->foreign('id_seguro')->references('id')->on('seguros');
        });
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguros_planes');
    }
}
