<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatosToPlanContablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_contables', function (Blueprint $table) {
            $table->string('cuenta',25)->nullable();
            $table->Integer('id_tipo')->nullable();
            $table->string('denominacion',150)->nullable();
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_contables', function (Blueprint $table) {
            //
        });
    }
}
