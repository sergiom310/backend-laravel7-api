<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ConfJornadas;
use Illuminate\Http\Request;
use App\Http\Requests\API\ConfJornadasRequest;

class ConfJornadasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($page = \Request::get('page')) {
            $limit = \Request::get('limit') ? \Request::get('limit') : 20;
            $response = ConfJornadas::paginate($limit);
        } else {
            $response = ConfJornadas::all();
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
    public function store(ConfJornadasRequest $request)
    {
        try {
            $response = ConfJornadas::create($request->all());
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
     * @param  \App\Models\ConfJornadas  $confJornadas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = ConfJornadas::whereId($id)->get();

        return response()->json([
            "data" => $response
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConfJornadas  $confJornadas
     * @return \Illuminate\Http\Response
     */
    public function update(ConfJornadasRequest $request, $id)
    {
        $response = ConfJornadas::findOrFail($id);

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
     * @param  \App\Models\ConfJornadas  $confJornadas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = ConfJornadas::findOrFail($id);

        $response->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
