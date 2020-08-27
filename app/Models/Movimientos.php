<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'documento_id',
        'servicio_id',
        'valor_servicio',
        'valor_total',
        'cantidad',
    ];

    /**
     * Get the servicio that owns the movimiento.
     */
    public function servicio()
    {
        return $this->belongsTo('App\Models\Servicios');
    }

    /**
     * Get the documento that owns the movimiento.
     */
    public function documento()
    {
        return $this->belongsTo('App\Models\Documentos');
    }

}
