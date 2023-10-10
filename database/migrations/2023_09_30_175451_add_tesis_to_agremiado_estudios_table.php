<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTesisToAgremiadoEstudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agremiado_estudios', function (Blueprint $table) {
            $table->string('tesis',200)->nullable();
            $table->date('fecha_egresado')->nullable();
            $table->date('fecha_graduado')->nullable();
            $table->string('libro',20)->nullable();
            $table->string('folio',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agremiado_estudios', function (Blueprint $table) {
            //
        });
    }
}
