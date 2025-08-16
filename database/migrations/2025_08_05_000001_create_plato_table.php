<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatosTable extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up()
    {
        Schema::create('platos', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->unsignedBigInteger('idcategoriaplatos'); // Clave foránea
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio', 8, 2);
            $table->string('tipo');
            $table->timestamps();

            // Relación con la tabla categorias_platos
            $table->foreign('idcategoriaplatos')->references('id')->on('categorias_platos');
        });
    }

    /**
     * Revierte la migración.
     */
    public function down()
    {
        Schema::dropIfExists('platos');
    }

}