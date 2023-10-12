<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMontoToConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conceptos', function (Blueprint $table) {
            $table->double('importe',15,8)->nullable();
            $table->bigInteger('id_tipo_afectacion')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conceptos', function (Blueprint $table) {
            //
        });
    }
}
