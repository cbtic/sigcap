<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbigeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubigeos', function (Blueprint $table) {
            $table->id();
            $table->string('id_ubigeo',6)->nullable();
            $table->string('id_departamento',2)->nullable();
            $table->string('id_provincia',2)->nullable();
            $table->string('id_distrito',2)->nullable();
            $table->string('desc_ubigeo',50)->nullable();
            $table->string('estado',1)->nullable()->default('1');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ubigeos');
    }
}
