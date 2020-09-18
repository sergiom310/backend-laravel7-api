<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Estados;
use Illuminate\Http\Request;
use App\Models\Bitacora;
use Carbon\Carbon;

class EstadosController extends Controller
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
            $Estados = Estados::paginate($limit);
        } else {
            $Estados = Estados::all();
        }

        return response()->json([
            "data" => $Estados
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
            'required' => 'El nombre del estado es requerida.',
            'max'      => 'El nombre del estado debe ser máximo 50 caracteres.'
        ];
        $validator = \Validator::make($request->all(), [
            'nom_estado' => 'required|max:50'
        ], $messages);

        if ($validator->passes()) {
            $Estados = Estados::create($request->all());

            return response()->json([
                "data" => $Estados
            ], 201);
        }

        return response()->json(['error' => $validator->errors()->all()], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estados  $Estados
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Estados = Estados::whereId($id)->get();

        return response()->json([
            "data" => $Estados
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estados  $Estados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Estados = Estados::findOrFail($id);

        $messages = [
            'required' => 'El nombre del estado es requerida.',
            'max'      => 'El nombre del estado debe ser máximo 50 caracteres.'
        ];
        $validator = \Validator::make($request->all(), [
            'nom_estado' => 'required|max:50'
        ], $messages);

        if ($validator->passes()) {
            $obsBitacora = $Estados->toJson();

            $Bitacora = Bitacora::create([
                'tabla_id' => $id,
                'user_id' => \Auth::user()->id,
                'nom_tabla' => 'estados',
                'estado_id' => $Estados->estatus,
                'estatus' => 4,
                'created_at' => Carbon::now(),
                'obs_bitacora' => $obsBitacora
            ]);

            $Estados->update($request->all());
            return response()->json(['success' => 'Registro actualizado exitosamente'], 201);
        }

        return response()->json(['error' => 'Error actualizando BD!'], 422);
    }

    /**
     * Reverse the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reverseestado(Request $request, $id)
    {
        $Estados = Estados::findOrFail($id);

        $Estados->update(['estatus' => 2]);

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
        $Estados = Estados::findOrFail($id);

        $obsBitacora = $Estados->toJson();

        $Bitacora = Bitacora::create([
            'tabla_id' => $id,
            'user_id' => \Auth::user()->id,
            'nom_tabla' => 'estados',
            'estado_id' => $Estados->estatus,
            'estatus' => 2,
            'created_at' => Carbon::now(),
            'obs_bitacora' => $obsBitacora
        ]);

        $Estados->update(['estatus' => 5]);

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
        $Estados = Estados::findOrFail($id);

        $obsBitacora = $Estados->toJson();

        $Bitacora = Bitacora::create([
            'tabla_id' => $id,
            'user_id' => \Auth::user()->id,
            'nom_tabla' => 'estados',
            'estado_id' => 13,
            'estatus' => 2,
            'created_at' => Carbon::now(),
            'obs_bitacora' => $obsBitacora
        ]);

        $Estados->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
