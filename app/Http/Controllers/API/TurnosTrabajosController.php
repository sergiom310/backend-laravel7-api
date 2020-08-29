<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TurnosTrabajos;
use Illuminate\Http\Request;
use App\Http\Requests\API\TurnosTrabajosRequest;
use Carbon\Carbon;

class TurnosTrabajosController extends Controller
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
            $response = TurnosTrabajos::paginate($limit);
        } else {
            $response = TurnosTrabajos::all();
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
    public function store(TurnosTrabajosRequest $request)
    {
        try {
            $request['fecha'] = Carbon::now();
            $response = TurnosTrabajos::create($request->all());
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
     * @param  \App\Models\TurnosTrabajos  $turnosTrabajos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = TurnosTrabajos::whereId($id)->get();

        return response()->json([
            "data" => $response
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TurnosTrabajos  $turnosTrabajos
     * @return \Illuminate\Http\Response
     */
    public function update(TurnosTrabajosRequest $request, $id)
    {
        $response = TurnosTrabajos::findOrFail($id);

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
     * @param  \App\Models\TurnosTrabajos  $turnosTrabajos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = TurnosTrabajos::findOrFail($id);

        $response->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
