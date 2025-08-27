<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};