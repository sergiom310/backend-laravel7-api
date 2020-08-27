<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sedes;
use Illuminate\Http\Request;
use App\Http\Requests\API\SedesRequest;

class SedesController extends Controller
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
            $response = Sedes::paginate($limit);
        } else {
            //FROM sedes s JOIN definiciones d ON s.estado_id = d.id JOIN users uc ON s.user_created_at = uc.id JOIN users uu ON s.user_updated_at = uu.id JOIN users ur ON s.representante_sede = ur.id JOIN consecutivos c ON s.consecutivo_id = c.id
            $response = \DB::table('sedes')
                ->join('consecutivos', 'sedes.consecutivo_id', '=', 'consecutivos.id')
                ->join('definiciones', 'sedes.estado_id', '=', 'definiciones.id')
                ->join('users AS uc', 'sedes.user_created_at', '=', 'uc.id')
                ->join('users AS uu', 'sedes.user_updated_at', '=', 'uu.id')
                ->join('users AS ur', 'sedes.representante_sede', '=', 'ur.id')
                ->selectRaw("
                    sedes.id,
                    sedes.estado_id,
                    des_definicion,
                    sedes.user_created_at,
                    uc.name AS name_created,
                    sedes.user_updated_at,
                    uu.name AS name_updated,
                    nom_sede,
                    representante_sede,
                    ur.name AS name_representante,
                    consecutivo_id,
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
    public function store(SedesRequest $request)
    {
        try {
            $request['user_created_at'] = \Auth::user()->id;
            $request['user_updated_at'] = \Auth::user()->id;
            $response = Sedes::create($request->all());
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
        $response = Sedes::whereId($id)->get();

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
    public function update(SedesRequest $request, $id)
    {
        $response = Sedes::findOrFail($id);

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
        $response = Sedes::findOrFail($id);

        $response->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
