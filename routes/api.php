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

    // * rutas para reversar el borrado lógico *
    Route::put('reversetipohab/{id}', 'API\TipoHabitacionController@reversetipohab');
    Route::put('reversetipodoc/{id}', 'API\TipoDocumentoController@reversetipodoc');
    Route::put('reversetipoiden/{id}', 'API\TipoIdentificacionController@reversetipoiden');
    Route::put('reversetiposerv/{id}', 'API\TipoServicioController@reversetiposerv');
    Route::put('reverseturnotrab/{id}', 'API\TurnosTrabajosController@reverseturnotrab');
    Route::put('reverseservicio/{id}', 'API\ServiciosController@reverseservicio');
    Route::put('reversereserva/{id}', 'API\ReservacionesController@reversereserva');
    Route::put('reversemovimien/{id}', 'API\MovimientosController@reversemovimien');
    Route::put('reversehabitacion/{id}', 'API\HabitacionesController@reversehabitacion');
    Route::put('reverseestado/{id}', 'API\EstadosController@reverseestado');
    Route::put('reversedocumento/{id}', 'API\DocumentosController@reversedocumento');
    Route::put('reversecliente/{id}', 'API\ClientesController@reversecliente');

    // * rutas para el borrado físico *
    Route::put('deletetipohab/{id}', 'API\TipoHabitacionController@delete');
    Route::put('deletetipodoc/{id}', 'API\TipoDocumentoController@delete');
    Route::put('deletetipoiden/{id}', 'API\TipoIdentificacionController@delete');
    Route::put('deletetiposerv/{id}', 'API\TipoServicioController@delete');
    Route::put('deleteturnostrab/{id}', 'API\TurnosTrabajosController@delete');
    Route::put('deleteservicio/{id}', 'API\ServiciosController@delete');
    Route::put('deletereserva/{id}', 'API\ReservacionesController@delete');
    Route::put('deletemovimien/{id}', 'API\MovimientosController@delete');
    Route::put('deletehabitacion/{id}', 'API\HabitacionesController@delete');
    Route::put('deleteestado/{id}', 'API\EstadosController@delete');
    Route::put('deletedocumento/{id}', 'API\DocumentosController@delete');
    Route::put('deletecliente/{id}', 'API\ClientesController@delete');

    // * rutas módulo de roles y permisos *
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