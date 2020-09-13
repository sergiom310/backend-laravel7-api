<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'auth',
    'middleware' => 'cors'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {    
    Route::post('create', 'ResetPasswordController@create');
    Route::get('find/{token}', 'ResetPasswordController@find');
    Route::post('reset', 'ResetPasswordController@reset');
});

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::apiResources([
        'permission'         => 'API\PermissionController',
        'role'               => 'API\RoleController',
        'user'               => 'API\UserController',
        'bitacora'           => 'API\BitacoraController',
        'tiposervicio'       => 'API\TipoServicioController',
        'tipodocumento'      => 'API\TipoDocumentoController',
        'tipohabitacion'     => 'API\TipoHabitacionController',
        'estados'            => 'API\EstadosController',
        'tipoidentificacion' => 'API\TipoIdentificacionController',
        'tipoaccion'         => 'API\TipoAccionController',
        'turnostrabajos'     => 'API\TurnosTrabajosController',
        'movimientos'        => 'API\MovimientosController',
        'documentos'         => 'API\DocumentosController',
        'habitaciones'       => 'API\HabitacionesController',
        'servicios'          => 'API\ServiciosController',
        'reservaciones'      => 'API\ReservacionesController',
        'clientes'           => 'API\ClientesController',
    ]);

    Route::put('reversetipohab/{id}', 'API\TipoHabitacionController@reversetipohab');

    Route::get('permission2', 'API\PermissionController@indexPermissions');
    Route::get('permissionsrole/{id}', 'API\RoleController@permissions');
    Route::get('permissionsmodel/{id}', 'API\PermissionController@permissionsmodel');
    Route::put('permissionsmodel/{id}', 'API\PermissionController@updatepermissionsmodel');
});

Route::put('userstatus/{id}', 'API\UserController@activate');
Route::get('roles', 'API\UserController@roles');
Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');
Route::get('findUser', 'API\UserController@search');

Route::fallback(function(){
    return response()->json(['message' => 'Page Not Found.'], 404);
});