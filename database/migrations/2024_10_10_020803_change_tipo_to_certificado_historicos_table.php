<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTipoToCertificadoHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificado_historicos', function (Blueprint $table) {
            DB::statement("ALTER TABLE certificado_historicos alter column tipo TYPE varchar(20) USING (tipo::varchar(20));");
            //ALTER TABLE public.certificado_historicos ALTER COLUMN tipo TYPE varchar(20) USING tipo::varchar(20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificado_historicos', function (Blueprint $table) {
            //
        });
    }
}
