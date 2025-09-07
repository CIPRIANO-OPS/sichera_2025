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
        Schema::create('plato_categorias', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->string('nombre')->unique();
            $table->text('estado')->nullable(); // Descripción opcional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plato_categorias');
    }
};