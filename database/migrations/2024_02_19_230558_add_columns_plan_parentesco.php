<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsPlanParentesco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seguro_afiliado_parentescos', function (Blueprint $table) {
            $table->integer('id_plan')->nullable()->unsigned()->index(); 
             
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seguro_afiliado_parentescos', function (Blueprint $table) {
            //
        });
    }
}
