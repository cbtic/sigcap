<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIdConceptoToPlanContablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_contables', function (Blueprint $table) {
            $table->dropColumn('id_concepto');
            $table->dropColumn('id_plantilla detalle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_contables', function (Blueprint $table) {
            //
        });
    }
}
