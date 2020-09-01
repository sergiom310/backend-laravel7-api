<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIdentificacion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'tipo_identificacion';

    protected $fillable = [
        'tipo_identificacion',
        'des_tipo_identificacion',
        'estado_id'
    ];

    /**
     * Get the estado that owns the tipo_identificacion.
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Estados');
    }

    /**
     * Get the clientes for the tipo_identificacion.
     */
    public function clientes()
    {
        return $this->hasMany('App\Models\Clientes');
    }    

}
