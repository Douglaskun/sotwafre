<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('idPedido');
            // $table->unsignedBigInteger('idProducto');
            // $table->foreign('idProducto')->references('idProducto')->on('productos')->onDelete('cascade');
            $table->unsignedBigInteger('idMesa');
            $table->foreign('idMesa')->references('idMesa')->on('mesas')->onDelete('cascade');
            $table->unsignedBigInteger('idUsuario')->nullable();
            $table->foreign('idUsuario')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('estPed')->default(0);
            $table->decimal('subTotal', 8, 2);
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
        Schema::dropIfExists('pedidos');
    }
}
