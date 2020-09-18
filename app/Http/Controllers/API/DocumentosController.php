<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Documentos;
use Illuminate\Http\Request;
use App\Http\Requests\API\DocumentosRequest;
use App\Models\Bitacora;
use Carbon\Carbon;

class DocumentosController extends Controller
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
            $response = Documentos::paginate($limit);
        } else {
            $response = Documentos::all();
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
    public function store(DocumentosRequest $request)
    {
        try {
            $request['user_id_created_at'] = \Auth::id();
            $response = Documentos::create($request->all());
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
     * @param  \App\Models\Documentos  $documentos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Documentos::whereId($id)->get();

        return response()->json([
            "data" => $response
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documentos  $documentos
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentosRequest $request, $id)
    {
        $Documentos = Documentos::findOrFail($id);

        try {
            $obsBitacora = $Documentos->toJson();

            $Bitacora = Bitacora::create([
                'tabla_id' => $id,
                'user_id' => \Auth::user()->id,
                'nom_tabla' => 'documentos',
                'estado_id' => $Documentos->estatus,
                'estatus' => 4,
                'created_at' => Carbon::now(),
                'obs_bitacora' => $obsBitacora
            ]);

            $request['user_id_updated_at'] = \Auth::id();
            $Documentos->update($request->all());
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
    public function reversedocumento(Request $request, $id)
    {
        $Documentos = Documentos::findOrFail($id);

        $Documentos->update(['estatus' => 2]);

        return response()->json(['success' => 'Registro restaurado exitosamente'], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documentos  $documentos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Documentos = Documentos::findOrFail($id);

        $obsBitacora = $Documentos->toJson();

        $Bitacora = Bitacora::create([
            'tabla_id' => $id,
            'user_id' => \Auth::user()->id,
            'nom_tabla' => 'documentos',
            'estado_id' => $Documentos->estatus,
            'estatus' => 2,
            'created_at' => Carbon::now(),
            'obs_bitacora' => $obsBitacora
        ]);

        $Documentos->update(['estatus' => 5]);

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
        $Documentos = Documentos::findOrFail($id);

        $obsBitacora = $Documentos->toJson();

        $Bitacora = Bitacora::create([
            'tabla_id' => $id,
            'user_id' => \Auth::user()->id,
            'nom_tabla' => 'documentos',
            'estado_id' => 13,
            'estatus' => 2,
            'created_at' => Carbon::now(),
            'obs_bitacora' => $obsBitacora
        ]);

        $Documentos->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
