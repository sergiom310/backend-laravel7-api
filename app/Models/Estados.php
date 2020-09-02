<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom_estado','estatus'
    ];

    /**
     * Get the estado that owns the estado.
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Estados');
    }

    /**
     * Get the habitacines for the estado.
     */
    public function habitaciones()
    {
        return $this->hasMany('App\Models\Habitaciones');
    }    

    /**
     * Get the reservaciones for the estado.
     */
    public function reservaciones()
    {
        return $this->hasMany('App\Models\Reservaciones');
    }    

    /**
     * Get the turnosTrabajos for the estado.
     */
    public function turnosTrabajos()
    {
        return $this->hasMany('App\Models\TurnosTrabajos');
    }    
}
