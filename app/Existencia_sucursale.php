<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Existencia_sucursale extends Model
{
    protected $table = 'existencia_sucursales';
    protected $fillable = [
        'idsucursal','idarticulo','stock'
    ];

    public function articulo(){
        return $this->belongsTo('App\Articulo');
    }

    public function sucursal(){
        return $this->belongsTo('App\Sucursale');
    }
}
