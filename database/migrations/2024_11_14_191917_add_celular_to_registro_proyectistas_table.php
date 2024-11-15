<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCelularToRegistroProyectistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profesion_otros', function (Blueprint $table) {
            $table->string('celular1',10)->nullable();
			$table->string('celular2',10)->nullable();
			$table->string('email1',100)->nullable();
			$table->string('email2',100)->nullable();
			$table->string('direccion',400)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profesion_otros', function (Blueprint $table) {
            //
        });
    }
}
