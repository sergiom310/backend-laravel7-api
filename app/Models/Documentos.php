<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_documento_id',
        'reservaciones_id',
        'impuestos',
        'valor_total',
        'turno_trabajo_id',
        'user_id_created_at',
        'user_id_updated_at',
        'estatus',
    ];

    /**
     * Get the estado that owns the documento.
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Estados');
    }

    /**
     * Get the tipo_documento that owns the documentos.
     */
    public function tipoDocumento()
    {
        return $this->belongsTo('App\Models\TipoDocumento');
    }

    /**
     * Get the reservacion that owns the documento.
     */
    public function reservacion()
    {
        return $this->belongsTo('App\Models\Reservaciones');
    }

    /**
     * Get the turnoTrabajo that owns the documento.
     */
    public function turnoTrabajo()
    {
        return $this->belongsTo('App\Models\TurnosTrabajos');
    }

    /**
     * Get the users that owns the documento.
     */
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the movimientos of the documento.
     */
    public function movimientos()
    {
        return $this->hasMany('App\Models\Movimientos');
    }
}
