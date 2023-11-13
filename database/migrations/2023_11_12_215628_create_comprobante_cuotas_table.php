<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobanteCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_cuotas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_comprobante');
            $table->integer('item');            
            $table->double('monto',17,2)->nullable();
            $table->date('fecha_vencimiento');            
            
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
        Schema::dropIfExists('comprobante_cuotas');
    }
}
