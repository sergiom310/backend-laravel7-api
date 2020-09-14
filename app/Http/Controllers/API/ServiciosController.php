<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Servicios;
use Illuminate\Http\Request;
use App\Http\Requests\API\ServiciosRequest;

class ServiciosController extends Controller
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
            $Servicios = Servicios::paginate($limit);
        } else {
            $Servicios = Servicios::all();
        }

        return response()->json([
            "data" => $Servicios
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiciosRequest $request)
    {
        try {
            $response = Servicios::create($request->all());
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error creando el registro!'], 422);
        }

        return response()->json([
            "data" => $response
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicios  $Servicios
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Servicios = Servicios::whereId($id)->get();

        return response()->json([
            "data" => $Servicios
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servicios  $Servicios
     * @return \Illuminate\Http\Response
     */
    public function update(ServiciosRequest $request, $id)
    {
        $response = Servicios::findOrFail($id);

        try {
            $response->update($request->all());
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error actualizando BD!'], 422);
        }

        return response()->json(['success' => 'Registro actualizado exitosamente'], 201);
    }

    /**
     * mark the specified resource as deleted.
     *
     * @param  \App\Models\TipoServicio  $tipoServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Servicios = Servicios::findOrFail($id);

        $Servicios->delete();

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
        $Servicios = Servicios::findOrFail($id);

        $Servicios->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
