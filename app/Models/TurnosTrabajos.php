<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurnosTrabajos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estado_id',
        'nom_turno_trabajo',
        'hora_desde',
        'hora_hasta',
    ];

    /**
     * Get the estado that owns the turno_trabajo.
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Estados');
    }

    /**
     * Get the documento of the turno_trabajo.
     */
    public function movimientos()
    {
        return $this->hasMany('App\Models\Documentos');
    }
}
