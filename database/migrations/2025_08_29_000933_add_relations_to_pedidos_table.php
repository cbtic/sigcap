<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationsToPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Relación con usuario
            $table->foreignId('usuario_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Para invitados
            //$table->uuid('token_invitado')->nullable();
            // Totales (copiados del carrito al momento de generar el pedido)
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento_total', 12, 2)->default(0);
            $table->decimal('impuesto_total', 12, 2)->default(0);
            $table->decimal('envio_total', 12, 2)->default(0);
            $table->decimal('total_general', 12, 2)->default(0);

            // Estado del pedido
            $table->enum('estado', ['pendiente', 'pagado', 'cancelado'])
                  ->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            //
        });
    }
}
