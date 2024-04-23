<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdTipoReintegroToDelegadoReintegrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delegado_reintegros', function (Blueprint $table) {
            $table->bigInteger('id_tipo_reintegro')->nullable();
            $table->Integer('cantidad')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delegado_reintegros', function (Blueprint $table) {
            //
        });
    }
}
