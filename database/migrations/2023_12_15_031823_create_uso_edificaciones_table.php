<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsoEdificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uso_edificaciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_tipo_uso')->nullable();    
            $table->bigInteger('id_sub_tipo_uso')->nullable();    
            $table->double('area_techada',14,2)->nullable(); 
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            //$table->foreign('id_tipo_uso')->references('id')->on('tabla_maestras');
            //$table->foreign('id_sub_tipo_uso')->references('id')->on('tabla_maestras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uso_edificaciones');
    }
}
