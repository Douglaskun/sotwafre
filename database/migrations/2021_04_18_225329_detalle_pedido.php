<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DetallePedido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallepedido', function (Blueprint $table) {
            $table->bigIncrements('idDetallePedido');
            $table->unsignedBigInteger('idProducto');
            $table->foreign('idProducto')->references('idProducto')->on('productos')->onDelete('cascade');
            $table->unsignedBigInteger('idPedido');
            $table->foreign('idPedido')->references('idPedido')->on('pedidos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('preciounitario', 8, 2);
            $table->decimal('montSubDetPed', 8, 2);

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
        Schema::dropIfExists('detallepedido');
    }
}
