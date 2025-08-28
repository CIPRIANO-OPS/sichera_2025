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
        'descripcion',
        'precio'
    ];

    protected $casts = [
        'precio' => 'decimal:2'
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
        return $query->where('nombre', 'like', '%' . $termino . '%')
                    ->orWhere('descripcion', 'like', '%' . $termino . '%');
    }
}