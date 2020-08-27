<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tipo_documento';

    protected $fillable = [
        'des_tipo_documento'
    ];
   
    /**
     * Get the documentos for the tipo_documento.
     */
    public function documentos()
    {
        return $this->hasMany('App\Models\Documentos');
    }    
}
