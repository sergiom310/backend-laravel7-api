<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitaciones extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estado_id',
        'tipo_habitacion_id',
        'nom_habitacion',
    ];

    /**
     * Get the tipo_habitacion that owns the habitacion.
     */
    public function tipoHabitacion()
    {
        return $this->belongsTo('App\Models\TipoHabitacion');
    }

    /**
     * Get the estado that owns the habitacion.
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Estados');
    }

    /**
     * Get the reservacion of the cliente.
     */
    public function reservaciones()
    {
        return $this->hasMany('App\Models\Reservaciones');
    }
}
