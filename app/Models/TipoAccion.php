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
        'des_tipo_accion', 'estado_id'
    ];
   
    /**
     * Get the estado that owns the tipo_accion.
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Estados');
    }

    /**
     * Get the bitacora for the tipo_accion.
     */
    public function bitacora()
    {
        return $this->hasMany('App\Models\Bitacora');
    }    
}
