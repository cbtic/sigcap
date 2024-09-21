<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsSeguroPlanes2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seguros_planes', function (Blueprint $table) {
           // $table->integer('id_parentesco')->nullable()->unsigned()->index(); 
             
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seguros_planes', function (Blueprint $table) {
            //
        });
    }
}
