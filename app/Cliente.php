<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['idpersona','nota_corta'];

    

    public function persona(){
        return $this->belongsTo('App\Persona');
    }
}
