<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValorizacionEquivalentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valorizacion_equivalentes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_valorizacion_equiv')->nullable()->unsigned()->index();
            $table->bigInteger('id_valorizacion')->nullable()->unsigned()->index();
            $table->bigInteger('id_persona')->nullable()->unsigned()->index();
            $table->bigInteger('id_empresa')->nullable()->unsigned()->index();
            $table->string('actual',1)->nullable()->default('1');
            $table->string('opcion',8)->nullable();
        
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
        Schema::dropIfExists('valorizacion_equivalentes');
    }
}
