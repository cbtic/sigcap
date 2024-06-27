<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionSesionDelegadosHistorialeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_sesion_delegados_historiales', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('id_comision_sesion_delegado')->nullable()->unsigned()->index();
			$table->bigInteger('id_delegado')->nullable()->unsigned()->index();
			$table->bigInteger('id_agremiado')->nullable()->unsigned()->index();
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
        Schema::dropIfExists('comision_sesion_delegados_historiale');
    }
}
