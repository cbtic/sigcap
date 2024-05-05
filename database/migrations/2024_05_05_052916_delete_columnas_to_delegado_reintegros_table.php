<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnasToDelegadoReintegrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delegado_reintegros', function (Blueprint $table) {
            $table->dropColumn('id_mes');
            $table->dropColumn('id_tipo_reintegro');
            $table->dropColumn('cantidad');
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
