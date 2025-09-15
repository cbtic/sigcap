<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMesToAgremiadoCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agremiado_cuotas', function (Blueprint $table) {
            DB::statement("ALTER TABLE agremiado_cuotas alter column mes TYPE INT USING (mes::integer);");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agremiado_cuotas', function (Blueprint $table) {
            //
        });
    }
}
