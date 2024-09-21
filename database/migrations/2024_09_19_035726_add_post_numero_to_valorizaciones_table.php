<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostNumeroToValorizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('valorizaciones', function (Blueprint $table) {
            $table->string('pagado_post',1)->nullable()->default('0');
            $table->string('nro_operacion_pos',250)->nullable();
            $table->date('fecha_pago_pos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('valorizaciones', function (Blueprint $table) {
            //
        });
    }
}
