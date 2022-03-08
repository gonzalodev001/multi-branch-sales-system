<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'idcliente',
        'idusuario',
        'idsucursal',
        'num_comprobante',
        'codigo_control',
        'fecha_hora',
        'impuesto',
        'total',
        'estado'
    ];
}
