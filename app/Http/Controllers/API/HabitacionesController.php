<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Habitaciones;
use Illuminate\Http\Request;
use App\Http\Requests\API\HabitacionesRequest;
use App\Models\Bitacora;
use Carbon\Carbon;

class HabitacionesController extends Controller
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
            $Habitaciones = Habitaciones::paginate($limit);
        } else {
            $Habitaciones = Habitaciones::all();
        }

        return response()->json([
            "data" => $Habitaciones
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HabitacionesRequest $request)
    {
        try {
            $response = Habitaciones::create($request->all());
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
     * @param  \App\Models\Habitaciones  $Habitaciones
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Habitaciones = Habitaciones::whereId($id)->get();

        return response()->json([
            "data" => $Habitaciones
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Habitaciones  $Habitaciones
     * @return \Illuminate\Http\Response
     */
    public function update(HabitacionesRequest $request, $id)
    {
        $Habitaciones = Habitaciones::findOrFail($id);

        try {
            $obsBitacora = $Habitaciones->toJson();

            $Bitacora = Bitacora::create([
                'tabla_id' => $id,
                'user_id' => \Auth::user()->id,
                'nom_tabla' => 'habitaciones',
                'estado_id' => $Habitaciones->estatus,
                'estatus' => 4,
                'created_at' => Carbon::now(),
                'obs_bitacora' => $obsBitacora
            ]);

            $Habitaciones->update($request->all());
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error actualizando BD!'], 422);
        }

        return response()->json(['success' => 'Registro actualizado exitosamente'], 201);
    }

    /**
     * Reverse the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reversehabitacion(Request $request, $id)
    {
        $Habitaciones = Habitaciones::findOrFail($id);

        $Habitaciones->update(['estatus' => 2]);

        return response()->json(['success' => 'Registro restaurado exitosamente'], 201);

    }

    /**
     * mark the specified resource as deleted.
     *
     * @param  \App\Models\TipoServicio  $tipoServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Habitaciones = Habitaciones::findOrFail($id);

        $obsBitacora = $Habitaciones->toJson();

        $Bitacora = Bitacora::create([
            'tabla_id' => $id,
            'user_id' => \Auth::user()->id,
            'nom_tabla' => 'habitaciones',
            'estado_id' => $Habitaciones->estatus,
            'estatus' => 2,
            'created_at' => Carbon::now(),
            'obs_bitacora' => $obsBitacora
        ]);

        $Habitaciones->update(['estatus' => 5]);

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
        $Habitaciones = Habitaciones::findOrFail($id);

        $obsBitacora = $Habitaciones->toJson();

        $Bitacora = Bitacora::create([
            'tabla_id' => $id,
            'user_id' => \Auth::user()->id,
            'nom_tabla' => 'habitaciones',
            'estado_id' => 13,
            'estatus' => 2,
            'created_at' => Carbon::now(),
            'obs_bitacora' => $obsBitacora
        ]);

        $Habitaciones->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
