<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsAgremiadoCuota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agremiado_cuotas', function (Blueprint $table) {
           $table->integer('id_familia')->nullable()->unsigned()->index(); 
             
             
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
