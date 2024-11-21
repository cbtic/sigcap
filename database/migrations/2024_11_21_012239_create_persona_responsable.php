<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaResponsable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona_responsable', function (Blueprint $table) {
        
            
                $table->id();
                $table->bigInteger('id_persona')->nullable()->unsigned()->index();
                $table->bigInteger('id_dempresa')->nullable()->unsigned()->index();
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
        Schema::dropIfExists('persona_responsable');
    }
}
