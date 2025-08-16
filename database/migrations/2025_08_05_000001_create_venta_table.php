<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->unsignedBigInteger('idventa');
            $table->unsignedBigInteger('idpedidos');
            $table->unsignedBigInteger('idcuenta')->nullable();
            $table->date('fecha')->nullable();
            $table->unsignedBigInteger('idcomandas')->nullable();
            $table->unsignedBigInteger('idcliente')->nullable();
            $table->string('nombreCliente', 255)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('totalgrabado', 10, 2)->nullable();
            $table->string('Campo', 255)->nullable();

            $table->primary(['idventa', 'idpedidos']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}