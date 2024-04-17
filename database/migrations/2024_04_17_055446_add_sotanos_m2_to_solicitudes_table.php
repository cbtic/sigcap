<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSotanosM2ToSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->string('sotanos_m2',50)->nullable();
            $table->string('semisotano_m2',50)->nullable();
            $table->string('piso_nivel_m2',50)->nullable();
            $table->string('otro_piso_nivel_m2',50)->nullable();
            $table->string('total_area_techada_m2',50)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            //
        });
    }
}
