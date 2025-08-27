<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $table = 'mesas';
    protected $primaryKey = 'pk';

    protected $fillable = [
        'id',
        'estado',
        'numero'
    ];

    protected $casts = [
        'numero' => 'integer'
    ];

    // Estados disponibles para las mesas
    const ESTADO_DISPONIBLE = 'disponible';
    const ESTADO_OCUPADO = 'ocupado';
    const ESTADO_RESERVADO = 'reservado';
    const ESTADO_POR_DESOCUPAR = 'por_desocupar';

    public static function getEstados()
    {
        return [
            self::ESTADO_DISPONIBLE => 'Disponible',
            self::ESTADO_OCUPADO => 'Ocupado',
            self::ESTADO_RESERVADO => 'Reservado',
            self::ESTADO_POR_DESOCUPAR => 'Por Desocupar'
        ];
    }

    // Scope para filtrar por estado
    public function scopeDisponibles($query)
    {
        return $query->where('estado', self::ESTADO_DISPONIBLE);
    }

    public function scopeOcupadas($query)
    {
        return $query->where('estado', self::ESTADO_OCUPADO);
    }

    // Método para verificar si la mesa está disponible
    public function estaDisponible()
    {
        return $this->estado === self::ESTADO_DISPONIBLE;
    }

    // Método para obtener el color de estado para la vista
    public function getColorEstado()
    {
        switch ($this->estado) {
            case self::ESTADO_DISPONIBLE:
                return 'success';
            case self::ESTADO_OCUPADO:
                return 'danger';
            case self::ESTADO_RESERVADO:
                return 'warning';
            case self::ESTADO_POR_DESOCUPAR:
                return 'info';
            default:
                return 'secondary';
        }
    }
}
