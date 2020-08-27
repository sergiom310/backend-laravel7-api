<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tipo_servicio';

    protected $fillable = [
        'des_tipo_servicio'
    ];
   
    /**
     * Get the servicios for the tipo_servicio.
     */
    public function servicios()
    {
        return $this->hasMany('App\Models\Servicios');
    }    
}
