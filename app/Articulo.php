<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $filable = [
        'idcategoria','nombre','marca','numero_serie','modelo','precio_venta','stock','descripcion','condicion'
    ];

    public function categoria(){
        return $this->belongsTo('App\Categoria'); 
    }

    public function existencia_sucursales(){
        return $this->hasMany('App\Existencia_sucursale'); 
    }
}
