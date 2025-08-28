<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plato extends Model
{
    use HasFactory;

    protected $table = 'platos';

    protected $fillable = [
        'idcategoriaplatos',
        'nombre',
        'descripcion',
        'precio',
        'tipo',
        'estado'
    ];

    protected $casts = [
        'precio' => 'decimal:2'
    ];

    /**
     * Relación muchos a uno con plato_categorias
     */
    public function categoria()
    {
        return $this->belongsTo(PlatoCategoria::class, 'idcategoriaplatos');
    }

    /**
     * Scope para buscar por nombre o descripción
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'like', '%' . $termino . '%')
            ->orWhere('descripcion', 'like', '%' . $termino . '%')
            ->orWhere('tipo', 'like', '%' . $termino . '%');
    }

    /**
     * Scope para filtrar por categoría
     */
    public function scopePorCategoria($query, $categoriaId)
    {
        return $query->where('idcategoriaplatos', $categoriaId);
    }

    /**
     * Scope para filtrar por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
