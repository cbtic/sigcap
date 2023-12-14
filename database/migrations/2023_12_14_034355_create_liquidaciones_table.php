<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('id_solicitud')->nullable();    
            $table->date('fecha')->nullable();       
            $table->string('credipago',50)->nullable();
            $table->double('sub_total',17,2)->nullable();
            $table->double('igv',17,2)->nullable();       
            $table->double('total',17,2)->nullable();
            $table->string('observacion',5000)->nullable();
            
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_solicitud')->references('id')->on('solicitudes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liquidaciones');
    }
}
