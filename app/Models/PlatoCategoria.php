<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatoCategoria extends Model
{
    use HasFactory;

    protected $table = 'plato_categorias';

    protected $fillable = [
        'nombre',
        'estado'
    ];

    protected $casts = [
        
    ];

    /**
     * Relación uno a muchos con platos
     */
    public function platos()
    {
        return $this->hasMany(Plato::class, 'idcategoriaplatos');
    }

    /**
     * Scope para buscar por nombre
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'like', '%' . $termino . '%');

    }
}