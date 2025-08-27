<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
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
