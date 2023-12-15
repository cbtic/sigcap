<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropietariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propietarios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_tipo_propietario')->nullable();
            $table->bigInteger('id_persona')->nullable();
            $table->bigInteger('id_empresa')->nullable();
            $table->string('representante',50)->nullable();
            $table->string('celular',50)->nullable();
            $table->string('email',50)->nullable();
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();

            //$table->foreign('id_tipo_propietario')->references('id')->on('tabla_maestras');
            $table->foreign('id_persona')->references('id')->on('personas');
            $table->foreign('id_empresa')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propietarios');
    }
}
