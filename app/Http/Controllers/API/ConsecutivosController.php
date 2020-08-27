<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Consecutivos;
use Illuminate\Http\Request;
use App\Http\Requests\API\ConsecutivosRequest;

class ConsecutivosController extends Controller
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
            $response = Consecutivos::paginate($limit);
        } else {
            $response = \DB::table('consecutivos')
                ->join('definiciones', 'consecutivos.estado_id', '=', 'definiciones.id')
                ->join('users AS uc', 'consecutivos.user_created_at', '=', 'uc.id')
                ->join('users AS uu', 'consecutivos.user_updated_at', '=', 'uu.id')
                ->selectRaw("
                    consecutivos.id,
                    estado_id,
                    des_definicion,
                    user_created_at,
                    uc.name AS name_created,
                    user_updated_at,
                    uu.name AS name_updated,
                    prefijo,
                    consecutivo,
                    consecutivo_desde,
                    consecutivo_hasta,
                    consecutivo_alerta,
                    DATE_FORMAT(consecutivo_vct, '%Y-%m-%d') AS consecutivo_vct,
                    des_consecutivo
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
    public function store(ConsecutivosRequest $request)
    {
        try {
            $request['user_created_at'] = \Auth::user()->id;
            $request['user_updated_at'] = \Auth::user()->id;
            $response = Consecutivos::create($request->all());
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
        $response = Consecutivos::whereId($id)->get();

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
    public function update(ConsecutivosRequest $request, $id)
    {
        $response = Consecutivos::findOrFail($id);

        try {
            $request['user_updated_at'] = \Auth::user()->id;
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
        $response = Consecutivos::findOrFail($id);

        $response->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
