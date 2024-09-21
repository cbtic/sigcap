<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsientoPlanillaDelegadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asiento_planilla_delegados', function (Blueprint $table) {
            $table->id();       
            $table->bigInteger('id_planilla')->nullable();
            $table->string('origen',250)->nullable();
            $table->string('vou',250)->nullable();
            $table->string('fecha',250)->nullable();
            $table->string('cuenta',250)->nullable();
            $table->string('debe',250)->nullable();
            $table->string('haber',250)->nullable();
            $table->string('moneda',250)->nullable();
            $table->string('tc',250)->nullable();
            $table->string('doc',250)->nullable();
            $table->string('numero',250)->nullable();
            $table->string('fechad',250)->nullable();
            $table->string('fechav',250)->nullable();
            $table->string('codigo',250)->nullable();
            $table->string('cc',250)->nullable();
            $table->string('pre',250)->nullable();
            $table->string('fe',250)->nullable();
            $table->string('glosa',250)->nullable();
            $table->string('tl',250)->nullable();
            $table->string('neto1',250)->nullable();
            $table->string('neto2',250)->nullable();
            $table->string('neto3',250)->nullable();
            $table->string('neto4',250)->nullable();
            $table->string('neto5',250)->nullable();
            $table->string('neto6',250)->nullable();
            $table->string('neto7',250)->nullable();
            $table->string('neto8',250)->nullable();
            $table->string('neto9',250)->nullable();
            $table->string('igv',250)->nullable();
            $table->string('rdoc',250)->nullable();
            $table->string('rnum',250)->nullable();            
            $table->string('rfec',250)->nullable();
            $table->string('snum',250)->nullable();
            $table->string('sfec',250)->nullable();
            $table->string('ruc',250)->nullable();
            $table->string('rs',250)->nullable();
            $table->string('tipo',250)->nullable();
            $table->string('tdoci',250)->nullable();
            $table->string('mpago',250)->nullable();
            $table->string('ape1',250)->nullable();
            $table->string('ape2',250)->nullable();
            $table->string('nombre',250)->nullable();
            $table->string('tbien',250)->nullable();
            $table->string('refmonto',250)->nullable();
            
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
        Schema::dropIfExists('asiento_planilla_delegados');
    }
}
