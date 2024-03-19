<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUbigeoToDelegadoFondoComunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delegado_fondo_comuns', function (Blueprint $table) {
            $table->string('id_ubigeo',6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delegado_fondo_comuns', function (Blueprint $table) {
            //
        });
    }
}
