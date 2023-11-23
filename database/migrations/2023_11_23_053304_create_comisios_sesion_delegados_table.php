<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisiosSesionDelegadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_sesion_delegados', function (Blueprint $table) {
            $table->id(); 
            $table->integer('id_delegado')->nullable();           
            $table->integer('id_profesion_otro')->nullable();
            $table->integer('id_aprobar_pago')->nullable();
            $table->string('observaciones',5000)->nullable();
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            $table->foreign('id_delegado')->references('id')->on('comision_delegados');
            $table->foreign('id_profesion_otro')->references('id')->on('profesion_otros');
   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comisios_sesion_delegados');
    }
}
