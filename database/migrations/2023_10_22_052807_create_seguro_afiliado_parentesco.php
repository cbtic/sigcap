<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguroAfiliadoParentesco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('seguro_afiliado_parentesco', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_afiliacion')->unsigned()->index();
            $table->bigInteger('id_agremiado')->unsigned()->index();
            $table->bigInteger('id_familia')->unsigned()->index();            
            $table->bigInteger('edad')->unsigned()->index();            
            $table->bigInteger('sexo')->unsigned()->index();            
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            $table->timestamps();

            $table->foreign('id_afiliacion')->references('id')->on('seguro_afiliados');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguro_afiliado_parentesco');
    }
}
