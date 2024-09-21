<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_documentos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_tipo_documento')->nullable();    
            $table->string('descripcion',250)->nullable();    
            $table->string('ruta_archivo',255)->nullable(); 
            $table->string('estado',1)->nullable()->default('1');
 
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index(); 
            $table->timestamps();
            
            //$table->foreign('id_tipo_documento')->references('id')->on('tabla_maestras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud_documentos');
    }
}
