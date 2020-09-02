<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TipoHabitacion;
use Illuminate\Http\Request;

class TipoHabitacionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('permission:usuario.index', ['only' => ['index', 'show']]);
        $this->middleware('permission:usuario.create', ['only' => ['store']]);
        $this->middleware('permission:usuario.update', ['only' => ['update', 'desActivar']]);
        $this->middleware('permission:usuario.destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($page = \Request::get('page')) {
            $limit = \Request::get('limit') ? \Request::get('limit') : 20;
            $TipoHabitacion = TipoHabitacion::paginate($limit);
        } else {
            $TipoHabitacion = TipoHabitacion::join('estados', 'tipo_habitacion.estatus', '=', 'estados.id')->get();
        }

        return response()->json([
            "data" => $TipoHabitacion
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'La descripción del tipo de habitación es requerida.',
            'max'      => 'La descripción del tipo de habitación debe ser máximo 50 caracteres.'
        ];
        $validator = \Validator::make($request->all(), [
            'des_tipo_habitacion' => 'required|max:50'
        ], $messages);

        if ($validator->passes()) {
            $TipoHabitacion = TipoHabitacion::create($request->all());

            return response()->json([
                "data" => $TipoHabitacion
            ], 201);
        }

        return response()->json(['error' => $validator->errors()->all()], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $TipoHabitacion = TipoHabitacion::whereId($id)->get();

        return response()->json([
            "data" => $TipoHabitacion
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $TipoHabitacion = TipoHabitacion::findOrFail($id);

        $messages = [
            'required' => 'La descripción del tipo de habitación es requerida.',
            'max'      => 'La descripción del tipo de habitación debe ser máximo 50 caracteres.'
        ];
        $validator = \Validator::make($request->all(), [
            'des_tipo_habitacion' => 'required|max:50'
        ], $messages);

        if ($validator->passes()) {
            $request['estatus'] = 4;
            $TipoHabitacion->update($request->all());
            return response()->json(['success' => 'Registro actualizado exitosamente'], 201);
        }

        return response()->json(['error' => 'Error actualizando BD!'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $TipoHabitacion = TipoHabitacion::findOrFail($id);

        $TipoHabitacion->update(['estatus' => 5]);

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
