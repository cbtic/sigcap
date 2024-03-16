<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptoEmpresaBeneficiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepto_empresa_beneficiarios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_persona')->nullable();
            $table->bigInteger('id_empresa')->nullable();
            $table->string('periodo',20)->nullable();
            $table->bigInteger('id_concepto')->nullable();
            $table->string('estado_beneficiario',1)->nullable();
            $table->string('observacion',250)->nullable();
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_persona')->references('id')->on('personas');
            $table->foreign('id_empresa')->references('id')->on('empresas');
            $table->foreign('id_concepto')->references('id')->on('conceptos');

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
        Schema::dropIfExists('concepto_empresa_beneficiarios');
    }
}
