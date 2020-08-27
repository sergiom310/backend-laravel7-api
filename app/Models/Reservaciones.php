<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservaciones extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cliente_id',
        'habitacion_id',
        'estado_id',
        'check_in',
        'chech_out',
    ];

    /**
     * Get the estado that owns the reservacion.
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Estados');
    }

    /**
     * Get the cliente that owns the reservacion.
     */
    public function cliente()
    {
        return $this->belongsTo('App\Models\Clientes');
    }

    /**
     * Get the habitacion that owns the reservacion.
     */
    public function habitacion()
    {
        return $this->belongsTo('App\Models\Habitaciones');
    }

    /**
     * Get the documento of the turno_trabajo.
     */
    public function movimientos()
    {
        return $this->hasMany('App\Models\Documentos');
    }
}
