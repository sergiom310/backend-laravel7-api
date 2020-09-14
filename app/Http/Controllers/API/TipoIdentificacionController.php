<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TipoIdentificacion;
use Illuminate\Http\Request;

class TipoIdentificacionController extends Controller
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
            $TipoIdentificacion = TipoIdentificacion::select(
                'tipo_identificacion.id',
                'tipo_identificacion',
                'des_tipo_identificacion',
                'tipo_identificacion.created_at',
                'tipo_identificacion.estatus',
                'nom_estado')
            ->join('estados', 'tipo_identificacion.estatus', '=', 'estados.id')
            ->whereNotIn('tipo_identificacion.estatus', [1, 5])
            ->paginate($limit);

            $TipoHabitacion = $TipoHabitacion->toArray();
            $TipoHabitacion = $TipoHabitacion['data'];
        } else {
            $TipoIdentificacion = TipoIdentificacion::select(
                'tipo_identificacion.id',
                'tipo_identificacion',
                'des_tipo_identificacion',
                'tipo_identificacion.created_at',
                'tipo_identificacion.estatus',
                'nom_estado')
            ->join('estados', 'tipo_identificacion.estatus', '=', 'estados.id')
            ->whereNotIn('tipo_identificacion.estatus', [1, 5])
            ->get();
        }

        return response()->json([
            "data" => $TipoIdentificacion
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
            'tipo_identificacion.required'     => 'El tipo de identificación es requerida.',
            'tipo_identificacion.max'          => 'El tipo de identificación debe ser máximo 5 caracteres.',
            'des_tipo_identificacion.required' => 'La descripción del tipo de identificación es requerida.',
            'des_tipo_identificacion.max'      => 'La descripción del tipo de identificación debe ser máximo 50 caracteres.'
        ];
        $validator = \Validator::make($request->all(), [
            'tipo_identificacion'     => 'required|max:5',
            'des_tipo_identificacion' => 'required|max:50'
        ], $messages);

        if ($validator->passes()) {
            $TipoIdentificacion = TipoIdentificacion::create($request->all());

            return response()->json([
                "data" => $TipoIdentificacion
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
        $TipoIdentificacion = TipoIdentificacion::whereId($id)->get();

        return response()->json([
            "data" => $TipoIdentificacion
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
        $TipoIdentificacion = TipoIdentificacion::findOrFail($id);

        $messages = [
            'tipo_identificacion.required'     => 'El tipo de identificación es requerida.',
            'tipo_identificacion.max'          => 'El tipo de identificación debe ser máximo 5 caracteres.',
            'des_tipo_identificacion.required' => 'La descripción del tipo de identificación es requerida.',
            'des_tipo_identificacion.max'      => 'La descripción del tipo de identificación debe ser máximo 50 caracteres.'
        ];
        $validator = \Validator::make($request->all(), [
            'tipo_identificacion'     => 'required|max:5',
            'des_tipo_identificacion' => 'required|max:50'
        ], $messages);

        if ($validator->passes()) {
            $TipoIdentificacion->update($request->all());
            return response()->json(['success' => 'Registro actualizado exitosamente'], 201);
        }

        return response()->json(['error' => 'Error actualizando BD!'], 422);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reversetipoiden(Request $request, $id)
    {
        $TipoIdentificacion = TipoIdentificacion::findOrFail($id);

        $TipoIdentificacion->update(['estatus' => 2]);

        return response()->json(['success' => 'Registro restaurado exitosamente'], 201);

    }

    /**
     * mark the specified resource as deleted.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $TipoIdentificacion = TipoIdentificacion::findOrFail($id);

        $TipoIdentificacion->update(['estatus' => 5]);

        return response()->json(['success' => 'Registro eliminado'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $TipoIdentificacion = TipoIdentificacion::findOrFail($id);

        $TipoIdentificacion->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
