<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComensalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comensal', function (Blueprint $table) {
            $table->bigIncrements('idComensal');
            $table->string('dniCome', 8);
            $table->string('nomCome', 75);
            $table->string('apeCome', 75);
            // $table->decimal('total', 8, 2)->nullable();
            // $table->unsignedBigInteger('idMesa')->nullable();
            // $table->foreign('idMesa')->references('idMesa')->on('mesas')->onDelete('cascade');
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
        Schema::dropIfExists('comensal');
    }
}
