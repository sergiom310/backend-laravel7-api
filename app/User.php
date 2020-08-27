<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject,MustVerifyEmail
{
    use Notifiable, HasRoles;

    protected $guard_name = 'api';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'photo',
        'activation_code',
        'phone',
        'mobile',
        'address',
        'tipo_documento',
        'documento',
        'empresa_id',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the bitacora for the user.
     */
    public function bitacora()
    {
        return $this->hasMany('App\Models\Bitacora');
    }

    /**
     * Get the documentos for the user.
     */
    public function documentos()
    {
        return $this->hasMany('App\Models\Documentos');
    }    

}
