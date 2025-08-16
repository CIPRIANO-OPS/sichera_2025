<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = ['idventa', 'idpedidos'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idventa',
        'idpedidos',
        'idcuenta',
        'fecha',
        'idcomandas',
        'idcliente',
        'nombreCliente',
        'total',
        'totalgrabado',
        'Campo',
    ];
 //
}
