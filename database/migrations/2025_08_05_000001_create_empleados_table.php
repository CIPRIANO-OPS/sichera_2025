<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id(); // PK autoincremental
            $table->string('dni', 20)->unique();
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('whatsapp', 20)->nullable();
            $table->string('direccion', 100)->nullable();
            $table->date('fechanac')->nullable();
            $table->decimal('sueldo', 10, 2)->default(0);
            $table->string('cargo', 50)->nullable();
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}