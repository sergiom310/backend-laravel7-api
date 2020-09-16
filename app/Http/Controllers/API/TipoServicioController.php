<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TipoServicio;
use App\Models\Bitacora;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TipoServicioController extends Controller
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
            $TipoServicio = TipoServicio::select(
                'tipo_servicio.id',
                'des_tipo_servicio',
                'tipo_servicio.created_at',
                'tipo_servicio.estatus',
                'nom_estado')
            ->join('estados', 'tipo_servicio.estatus', '=', 'estados.id')
            ->whereNotIn('tipo_servicio.estatus', [1, 5])
            ->paginate($limit);

            $TipoServicio = $TipoServicio->toArray();
            $TipoServicio = $TipoServicio['data'];
        } else {
            $TipoServicio = TipoServicio::select(
                'tipo_servicio.id',
                'des_tipo_servicio',
                'tipo_servicio.created_at',
                'tipo_servicio.estatus',
                'nom_estado')
            ->join('estados', 'tipo_servicio.estatus', '=', 'estados.id')
            ->whereNotIn('tipo_servicio.estatus', [1, 5])
            ->get();
        }

        return response()->json([
            "data" => $TipoServicio
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
            'required' => 'La descripción del tipo de servicio es requerida.',
            'max'      => 'La descripción del tipo de servicio debe ser máximo 50 caracteres.'
        ];
        $validator = \Validator::make($request->all(), [
            'des_tipo_servicio' => 'required|max:50'
        ], $messages);

        if ($validator->passes()) {
            $TipoServicio = TipoServicio::create($request->all());

            return response()->json([
                "data" => $TipoServicio
            ], 201);
        }

        return response()->json(['error' => $validator->errors()->all()], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoServicio  $tipoServicio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $TipoServicio = TipoServicio::whereId($id)->get();

        return response()->json([
            "data" => $TipoServicio
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoServicio  $tipoServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $TipoServicio = TipoServicio::findOrFail($id);
        $messages = [
            'required' => 'La descripción del tipo de servicio es requerida.',
            'max'      => 'La descripción del tipo de servicio debe ser máximo 50 caracteres.'
        ];
        $validator = \Validator::make($request->all(), [
            'des_tipo_servicio' => 'required|max:50'
        ], $messages);

        if ($validator->passes()) {
            $request['estatus'] = 4;
            $TipoServicio->update($request->all());
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
    public function reversetiposerv(Request $request, $id)
    {
        $TipoServicio = TipoServicio::findOrFail($id);

        $TipoServicio->update(['estatus' => 2]);

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
        $TipoServicio = TipoServicio::findOrFail($id);

        $obsBitacora = $TipoServicio->toJson();

        $Bitacora = Bitacora::create([
            'tabla_id' => $id,
            'user_id' => \Auth::user()->id,
            'nom_tabla' => 'tipo_servicio',
            'estado_id' => $TipoServicio->estatus,
            'estatus' => 2,
            'created_at' => Carbon::now(),
            'obs_bitacora' => $obsBitacora
        ]);

        $TipoServicio->update(['estatus' => 5]);

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
        $TipoServicio = TipoServicio::findOrFail($id);

        $obsBitacora = $TipoServicio->toJson();

        $Bitacora = Bitacora::create([
            'tabla_id' => $id,
            'user_id' => \Auth::user()->id,
            'nom_tabla' => 'tipo_servicio',
            'estado_id' => 13,
            'estatus' => 2,
            'created_at' => Carbon::now(),
            'obs_bitacora' => $obsBitacora
        ]);

        $TipoServicio->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
