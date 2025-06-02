<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigoFinancieros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo_financieros', function (Blueprint $table) {
            $table->id();

            $table->string('codigo',20)->nullable();
            $table->string('denominacion',200)->nullable();
            $table->string('sbs',50)->nullable();
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            
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
        Schema::dropIfExists('codigo_financieros');
    }
}
