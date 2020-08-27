<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'bitacora';

    protected $fillable = [
        'tipo_accion_id',
        'tabla_id',
        'user_id',
        'nom_tabla',
        'obs_bitacora',
        'fecha',
    ];

    /**
     * Get the user that owns the bitacora.
     */
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the tipo_accion that owns the bitacora.
     */
    public function tipoAccion()
    {
        return $this->belongsTo('App\Models\TipoAccion');
    }

}
