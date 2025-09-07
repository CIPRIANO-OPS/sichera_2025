<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class productoCategoria extends Model
{
use HasFactory;

    protected $table = 'producto_categorias';

    protected $fillable = [
        'nombre',
        'estado'
    ];

    protected $casts = [
        
    ];

    /**
     * Relación uno a muchos con productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'idcategoriaproductos');
    }

    /**
     * Scope para buscar por nombre
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'like', '%' . $termino . '%');

    }    //
}
