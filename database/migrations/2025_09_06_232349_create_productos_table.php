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
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->unsignedBigInteger('idcategoriaproductos'); // Clave foránea
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio', 8, 2);
            $table->string('tipo');
            $table->timestamps();

            // Relación con la tabla producto_categorias
            $table->foreign('idcategoriaproductos')->references('id')->on('producto_categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};