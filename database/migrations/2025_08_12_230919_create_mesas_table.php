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
        Schema::create('mesas', function (Blueprint $table) {
            $table->id('pk'); // Clave primaria personalizada
            $table->string('id')->unique(); // ID alternativo
            $table->enum('estado', ['disponible', 'ocupado', 'reservado', 'por_desocupar'])->default('disponible');
            $table->integer('numero')->unique();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};
