<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TiposDefiniciones;
use Illuminate\Http\Request;
use App\Http\Requests\API\TiposDefinicionesRequest;

class TiposDefinicionesController extends Controller
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
            $TipoDefiniciones = TiposDefiniciones::paginate($limit);
        } else {
            $TipoDefiniciones = TiposDefiniciones::all();
        }

        return response()->json([
            "data" => $TipoDefiniciones
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TiposDefinicionesRequest $request)
    {
        try {
            $TipoDefiniciones = TiposDefiniciones::create($request->all());
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error creando el registro!'], 422);
        }

        return response()->json([
            "data" => $TipoDefiniciones
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TiposDefiniciones  $tiposDefiniciones
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $TipoDefinicion = TiposDefiniciones::whereId($id)->get();

        return response()->json([
            "data" => $TipoDefinicion
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TiposDefiniciones  $tiposDefiniciones
     * @return \Illuminate\Http\Response
     */
    public function update(TiposDefinicionesRequest $request, $id)
    {
        $TipoDefinicion = TiposDefiniciones::findOrFail($id);

        try {
            $TipoDefinicion->update($request->all());
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error actualizando BD!'], 422);
        }

        return response()->json(['success' => 'Registro actualizado exitosamente'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TiposDefiniciones  $tiposDefiniciones
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $TipoDefinicion = TiposDefiniciones::findOrFail($id);

        $TipoDefinicion->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
