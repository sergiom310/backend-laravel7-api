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
        'des_tipo_habitacion'
    ];
   
    /**
     * Get the habitaciones for the tipo_habitacion.
     */
    public function habitaciones()
    {
        return $this->hasMany('App\Models\Habitaciones');
    }    
}
