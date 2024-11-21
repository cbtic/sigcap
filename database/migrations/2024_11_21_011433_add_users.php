<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('id_tipo_usuario')->nullable();
            $table->integer('id_tipo_profesional')->nullable();
            $table->integer('id_tipo_administrado')->nullable();
            $table->integer('validado')->nullable();
            $table->integer('id_usuario_valida')->nullable();
            $table->date('fecha_valida')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
