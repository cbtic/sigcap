<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTesisToAgremiadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agremiados', function (Blueprint $table) {            
            $table->dateTime('fecha')->nullable();            
            $table->string('grupo_sanguineo',5)->nullable();
            $table->string('desc_cliente',200)->nullable();
            $table->Integer('id_estado_civil')->nullable();
            $table->bigInteger('id_seguro_social')->nullable();
            $table->string('id_ubigeo_nacimiento',6)->nullable();
            $table->string('lugar_nacimiento',200)->nullable();
            $table->bigInteger('id_nacionalidad')->nullable();
            $table->string('id_ubigeo_domicilio',6)->nullable();
            $table->string('direccion',400)->nullable();
            $table->string('codigo_postal',20)->nullable();
            $table->bigInteger('id_local')->nullable();
            $table->string('referencia',200)->nullable();
            $table->string('telefono1',50)->nullable();
            $table->string('telefono2',50)->nullable();
            $table->string('celular1',50)->nullable();
            $table->string('celular2',50)->nullable();
            $table->string('email1',100)->nullable();
            $table->string('email2',100)->nullable();
            $table->date('fecha_colegiado')->nullable();
            $table->bigInteger('numero_regional')->nullable();
            $table->string('libro',10)->nullable();
            $table->string('folio',10)->nullable();
            $table->string('libro_nacional',10)->nullable();
            $table->string('folio_nacional',10)->nullable();
            $table->string('informacion_adicional',500)->nullable();
            $table->string('flag_correspondencia',1)->nullable();
            $table->bigInteger('id_categoria')->nullable();
            $table->date('fecha_actualiza')->nullable();
            $table->string('flag_confidencial',1)->nullable();
            $table->date('fecha_fallecido')->nullable();
            $table->bigInteger('id_autoriza_tramite')->nullable();
            $table->bigInteger('id_actividad_gremial')->nullable();
            $table->bigInteger('clave')->nullable();
            $table->string('desc_situacion_otro',10)->nullable();
            $table->string('flag_estado',1)->nullable();
            $table->string('numero_ruc',10)->nullable();
            $table->bigInteger('id_ubicacion')->nullable();
            $table->string('desc_cliente_Sunat',300)->nullable();
            $table->string('direccion_sunat',400)->nullable();
            $table->string('id_cliente_migracion',12)->nullable();
            $table->string('flag_migracion',1)->nullable();
            $table->string('firma',50)->nullable();

        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agremiados', function (Blueprint $table) {
            //
        });
    }
}
