<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCodigoItfCodigoRuToRevisorUrbanos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revisor_urbanos', function (Blueprint $table) {
            $table->string('codigo_itf', 50)->nullable()->change();
            $table->string('codigo_ru', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('revisor_urbanos', function (Blueprint $table) {
            //
        });
    }
}
