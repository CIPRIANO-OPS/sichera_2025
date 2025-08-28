<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
    
    'nombre',
    'apellido',
    'celular',
    'telefono',
    'fecha_nac',
    'correo',
    'direccion'
    ];	

//
}
