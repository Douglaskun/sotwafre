<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumos', function (Blueprint $table) {
            $table->bigIncrements('idConsumo');
            // $table->unsignedBigInteger('idProducto');
            // $table->foreign('idProducto')->references('idProducto')->on('productos')->onDelete('cascade');
            $table->unsignedBigInteger('idPedido');
            $table->foreign('idPedido')->references('idPedido')->on('pedidos')->onDelete('cascade');
            $table->unsignedBigInteger('idComensal');
            $table->foreign('idComensal')->references('idComensal')->on('comensal')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('total', 8, 2);
            $table->timestamp('fecha')->nullable();
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
        Schema::dropIfExists('consumos');
    }
}
