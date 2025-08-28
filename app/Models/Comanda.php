<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comanda extends Model
{
    protected $fillable = [
        'mesa_id',
        'numero_comanda',
        'estado',
        'total',
        'observaciones',
        'fecha_apertura',
        'fecha_cierre'
    ];

    protected $casts = [
        'fecha_apertura' => 'datetime',
        'fecha_cierre' => 'datetime',
        'total' => 'decimal:2'
    ];

    /**
     * Relación con Mesa
     */
    public function mesa(): BelongsTo
    {
        return $this->belongsTo(Mesa::class, 'mesa_id', 'pk');
    }

    /**
     * Relación con Pedidos
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Generar número de comanda automático
     */
    public static function generarNumeroComanda(): string
    {
        $ultimo = self::latest('id')->first();
        $numero = $ultimo ? $ultimo->id + 1 : 1;
        return 'COM-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Calcular total de la comanda
     */
    public function calcularTotal(): float
    {
        return $this->pedidos()->sum('subtotal');
    }

    /**
     * Actualizar total de la comanda
     */
    public function actualizarTotal(): void
    {
        $this->update(['total' => $this->calcularTotal()]);
    }
}
