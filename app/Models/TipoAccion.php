<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAccion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tipo_accion';

    protected $fillable = [
        'des_tipo_servicio'
    ];
   
    /**
     * Get the bitacora for the tipo_accion.
     */
    public function bitacora()
    {
        return $this->hasMany('App\Models\Bitacora');
    }    
}
