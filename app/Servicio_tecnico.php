<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio_tecnico extends Model
{
    //
    protected $fillable = [
        'idcliente',
        'idusuario',
        'idsucursal',
        'descipcion_equipo',
        'defectos_entrada',
        'defectos_salida',
        'fecha_hora',
        'fecha_hora_salida',
        'estado'
    ];
}
