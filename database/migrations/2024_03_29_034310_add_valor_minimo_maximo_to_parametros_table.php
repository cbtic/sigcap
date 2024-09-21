<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValorMinimoMaximoToParametrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parametros', function (Blueprint $table) {
            $table->double('valor_minimo_edificaciones',15,8)->nullable();
            $table->double('valor_maximo_edificaciones',15,8)->nullable();
            $table->double('valor_minimo_hu',15,8)->nullable();
            $table->double('valor_maximo_hu',15,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parametros', function (Blueprint $table) {
            //
        });
    }
}
