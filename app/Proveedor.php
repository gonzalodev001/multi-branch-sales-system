<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = ['idp','contacto','telefono_contacto'];

    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo('App\Persona','idp');
    }
}
