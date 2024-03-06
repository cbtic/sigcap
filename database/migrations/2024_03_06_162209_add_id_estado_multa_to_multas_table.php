<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdEstadoMultaToMultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('multas', function (Blueprint $table) {
			$table->integer('id_estado_multa')->nullable()->index();
            $table->string('observacion_multa',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multas', function (Blueprint $table) {
            //
        });
    }
}
