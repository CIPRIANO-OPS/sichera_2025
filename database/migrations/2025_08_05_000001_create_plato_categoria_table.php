<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatoCategoriasTable extends Migration
{
    public function up()
    {
        Schema::create('plato_categorias', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->string('nombre')->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 8, 2)->nullable(); // Precio opcional
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plato_categorias');
    }
}