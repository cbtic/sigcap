<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteNacimientoToAgremiadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agremiados', function (Blueprint $table) {
            $table->dropColumn('grupo_sanguineo');
            $table->dropColumn('id_ubigeo_nacimiento');
            $table->dropColumn('lugar_nacimiento');
            $table->dropColumn('id_nacionalidad');

            $table->dropColumn('numero_ruc');
            $table->dropColumn('desc_cliente_Sunat');
            $table->dropColumn('direccion_sunat');

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
