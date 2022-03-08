<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombre','numero_documento','direccion','telefono','email'];

    public function Clientes()
    {
        return $this->hasMany('App\Cliente'); 
    }

    public function proveedor()
    {
        return $this->hasOne('App\Proveedor');
    }
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
