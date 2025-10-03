<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaProvisionToAsientoPlanillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asiento_planillas', function (Blueprint $table) {
            //
            $table->date('fecha_provision')->nullable();
            $table->date('fecha_provision_cancela')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asiento_planillas', function (Blueprint $table) {
            //
        });
    }
}
