<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPersonaPagaToConceptoEmpresaBeneficiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concepto_empresa_beneficiarios', function (Blueprint $table) {
            $table->bigInteger('id_persona_paga')->nullable();
            $table->bigInteger('tipo_documento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('concepto_empresa_beneficiarios', function (Blueprint $table) {
            //
        });
    }
}
