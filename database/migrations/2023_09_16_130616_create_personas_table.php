<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('id_tipo_documento')->unsigned()->index();
			$table->string('numero_documento',15)->nullable();
			$table->string('apellido_paterno',40)->nullable();
			$table->string('apellido_materno',40)->nullable();
			$table->string('nombres',40)->nullable();
			$table->date('fecha_nacimiento')->nullable();
			$table->enum('sexo', ['F', 'M']);
			$table->string('foto',40)->nullable();
			$table->string('id_tipo_persona',20)->nullable();
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
        Schema::dropIfExists('personas');
    }
}
