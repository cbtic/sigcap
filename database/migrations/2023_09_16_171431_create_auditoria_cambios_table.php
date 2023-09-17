<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditoriaCambiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditoria_cambios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tabla',100)->nullable();
            $table->bigInteger('pk_registro')->unsigned()->index();
            $table->string('campo',100)->nullable();
            $table->string('valor_anterior',200)->nullable();
            $table->string('valor_nuevo',200)->nullable();
            $table->dateTime('fecha_hora')->nullable();
            $table->bigInteger('id_usuario')->unsigned()->index();
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
        Schema::dropIfExists('auditoria_cambios');
    }
}
