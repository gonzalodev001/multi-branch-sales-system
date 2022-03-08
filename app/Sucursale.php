<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursale extends Model
{
    protected $table = 'sucursales';
    protected $fillable = [
        'direccion','nombre'
    ];

    public function users()
    {
        return $this->hasMany('App\User'); 
    }

    public function existencia_sucursales(){
        return $this->hasMany('App\Existencia_sucursale'); 
    }
}
