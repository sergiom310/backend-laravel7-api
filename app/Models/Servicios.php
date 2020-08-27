<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_servicio_id',
        'habitacion_id',
        'nom_servicio',
    ];

    /**
     * Get the tipo_servicio that owns the servicio.
     */
    public function tipoServicio()
    {
        return $this->belongsTo('App\Models\TipoServicio');
    }

    /**
     * Get the habitacion that owns the servicio.
     */
    public function habitacion()
    {
        return $this->belongsTo('App\Models\Habitaciones');
    }

    /**
     * Get the movimiento of the servicio.
     */
    public function movimientos()
    {
        return $this->hasMany('App\Models\Movimientos');
    }
}
