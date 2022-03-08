<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $fillable = [
        'idproveedor',
        'idusuario',
        'idsucursal',
        'tipo_comprobante',
        'numero_comprobante',
        'fecha_hora',
        'impuesto',
        'total_compra',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo('App\User');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }
}
