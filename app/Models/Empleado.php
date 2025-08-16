<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'dni',
        'nombre', 
        'apellido', 
        'whatsapp', 
        'direccion', 
        'fechanac', 
        'sueldo', 
        'cargo'
    ];
  //
}
