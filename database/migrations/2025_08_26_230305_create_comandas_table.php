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
        Schema::create('comandas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mesa_id');
            $table->foreign('mesa_id')->references('pk')->on('mesas')->onDelete('cascade');
            $table->string('numero_comanda')->unique();
            $table->enum('estado', ['abierta', 'cerrada', 'cancelada'])->default('abierta');
            $table->decimal('total', 10, 2)->default(0.00);
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_apertura')->useCurrent();
            $table->timestamp('fecha_cierre')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comandas');
    }
};
