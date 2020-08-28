<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class TipoDocumentoController extends Controller
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
            $TipoDocumento = TipoDocumento::paginate($limit);
        } else {
            $TipoDocumento = TipoDocumento::all();
        }

        return response()->json([
            "data" => $TipoDocumento
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
            'required' => 'La descripción del tipo de documento es requerida.',
            'max'      => 'La descripción del tipo de documento debe ser máximo 50 caracteres.'
        ];
        $validator = \Validator::make($request->all(), [
            'des_tipo_documento' => 'required|max:50'
        ], $messages);

        if ($validator->passes()) {
            $TipoDocumento = TipoDocumento::create($request->all());

            return response()->json([
                "data" => $TipoDocumento
            ], 201);
        }

        return response()->json(['error' => $validator->errors()->all()], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoDocumento  $tipoDocumento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $TipoDocumento = TipoDocumento::whereId($id)->get();

        return response()->json([
            "data" => $TipoDocumento
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoDocumento  $tipoDocumento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $TipoDocumento = TipoDocumento::findOrFail($id);

        $messages = [
            'required' => 'La descripción del tipo de documento es requerida.',
            'max'      => 'La descripción del tipo de documento debe ser máximo 50 caracteres.'
        ];
        $validator = \Validator::make($request->all(), [
            'des_tipo_servicio' => 'required|max:50'
        ], $messages);

        if ($validator->passes()) {
            $TipoDocumento->update($request->all());
            return response()->json(['success' => 'Registro actualizado exitosamente'], 201);
        }

        return response()->json(['error' => 'Error actualizando BD!'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoServicio  $tipoServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $TipoDocumento = TipoDocumento::findOrFail($id);

        $TipoDocumento->delete();

        return response()->json(['success' => 'Registro eliminado'], 201);
    }
}
