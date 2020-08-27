<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Definiciones;
use Illuminate\Http\Request;
use App\Http\Requests\API\DefinicionesRequest;

class DefinicionesController extends Controller
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
            $response = Definiciones::paginate($limit);
        } else {
            //$response = Definiciones::all();
            $response = \DB::table('definiciones')
                ->join('tipos_definiciones', 'definiciones.tipo_definicion_id', '=', 'tipos_definiciones.id')
                ->selectRaw(
                    "definiciones.id,
                    cod_definicion,
                    des_definicion,
                    val_definicion,
                    conf_definicion,
                    tipo_definicion_id,
                    des_tipo_definicion
                    ")
                ->get();
        }

        return response()->json([
            "data" => $response
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DefinicionesRequest $request)
    {
        try {
            $response = Definiciones::create($request->all());
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
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Definiciones::whereId($id)->get();

        return response()->json([
            "data" => $response
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(DefinicionesRequest $request, $id)
    {
        $response = Definiciones::findOrFail($id);

        try {
            $response->update($request->all());
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error actualizando BD!'], 422);
        }

        return response()->json(['success' => 'Registro actualizado exitosamente'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Definiciones::findOrFail($id);

        $response->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
