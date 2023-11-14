<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionDelegadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_delegados', function (Blueprint $table) {
            $table->id();
            $table->integer('id_regional')->nullable()->unsigned()->index();
			$table->integer('id_comision')->nullable()->unsigned()->index();
            $table->integer('id_agremiado')->nullable()->unsigned()->index();
			$table->integer('id_puesto')->nullable()->unsigned()->index();
            $table->integer('id_situacion')->nullable()->unsigned()->index();            
            $table->string('coordinador',1)->nullable()->default('0');
            $table->string('observacion',500)->nullable();
            
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_regional')->references('id')->on('regiones');
            $table->foreign('id_comision')->references('id')->on('comisiones');
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
        Schema::dropIfExists('comision_delegados');
    }
}
