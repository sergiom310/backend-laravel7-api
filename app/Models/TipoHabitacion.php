<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tipo_habitacion';

    protected $fillable = [
        'des_tipo_habitacion', 'estado_id'
    ];
   
    /**
     * Get the estado that owns the tipo_habitacion.
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Estados');
    }

    /**
     * Get the habitaciones for the tipo_habitacion.
     */
    public function habitaciones()
    {
        return $this->hasMany('App\Models\Habitaciones');
    }    
}
