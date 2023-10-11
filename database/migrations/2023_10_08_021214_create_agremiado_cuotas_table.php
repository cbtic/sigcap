<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgremiadoCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agremiado_cuotas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_agremiado')->unsigned()->index();
            $table->bigInteger('id_regional')->unsigned()->index();
            $table->bigInteger('id_concepto')->unsigned()->index();
            $table->bigInteger('id_moneda')->unsigned()->index();
            $table->string('periodo',8)->nullable();            
            $table->double('importe',15,8)->nullable();
            $table->datetime('fecha_venc_pago')->nullable();                    
            $table->string('observacion',500)->nullable();            
            $table->bigInteger('id_situacion')->unsigned()->index();
            $table->bigInteger('id_exonerado')->unsigned()->index();
            $table->bigInteger('id_pronto_pago')->unsigned()->index();
            $table->bigInteger('id_seguro_plan')->unsigned()->index();
            $table->string('estado',1)->nullable()->default('1');
                        
            $table->foreign('id_agremiado')->references('id')->on('agremiados');
            $table->foreign('id_regional')->references('id')->on('regiones');

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
        Schema::dropIfExists('agremiado_cuotas');
    }
}
