<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsientoPlanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asiento_planillas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_persona')->unsigned()->index();
            $table->string('cuenta',50)->nullable();                    
            $table->double('debe',15,8)->nullable();
            $table->double('haber',15,8)->nullable();
            $table->string('glosa',250)->nullable();
            $table->string('centro_costo',50)->nullable();
            $table->string('presupuesto',50)->nullable();
            $table->string('codigo_financiero',50)->nullable();
            $table->string('medio_pago',50)->nullable();
            $table->integer('id_tipo_documento')->nullable();
            $table->string('serie',10)->nullable();
            $table->bigInteger('numero')->nullable();
            $table->datetime('fecha_documento',250)->nullable();
            $table->datetime('fecha_vencimiento',250)->nullable();
            $table->integer('id_moneda')->nullable();
            $table->double('tipo_cambio',15,8)->nullable();

            $table->integer('id_estado_doc')->nullable();

            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();  

            $table->foreign('id_persona')->references('id')->on('personas');

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
        Schema::dropIfExists('asiento_planillas');
    }
}
