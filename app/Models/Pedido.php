<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    protected $fillable = [
        'comanda_id',
        'plato_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'observaciones',
        'estado'
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'cantidad' => 'integer'
    ];

    /**
     * Relación con Comanda
     */
    public function comanda(): BelongsTo
    {
        return $this->belongsTo(Comanda::class);
    }

    /**
     * Relación con Plato
     */
    public function plato(): BelongsTo
    {
        return $this->belongsTo(Plato::class);
    }

    /**
     * Calcular subtotal automáticamente
     */
    public function calcularSubtotal(): float
    {
        return $this->cantidad * $this->precio_unitario;
    }

    /**
     * Boot method para calcular subtotal automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($pedido) {
            $pedido->subtotal = $pedido->calcularSubtotal();
        });

        static::saved(function ($pedido) {
            // Actualizar total de la comanda cuando se guarda un pedido
            $pedido->comanda->actualizarTotal();
        });

        static::deleted(function ($pedido) {
            // Actualizar total de la comanda cuando se elimina un pedido
            $pedido->comanda->actualizarTotal();
        });
    }
}
