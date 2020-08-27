<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_identificacion_id',
        'num_identificacion',
        'nom_cliente',
    ];

    /**
     * Get the tipo_identificacion that owns the cliente.
     */
    public function tipoIdentificacion()
    {
        return $this->belongsTo('App\Models\TipoIdentificacion');
    }

    /**
     * Get the reservacion of the cliente.
     */
    public function reservaciones()
    {
        return $this->hasMany('App\Models\Reservaciones');
    }
}
