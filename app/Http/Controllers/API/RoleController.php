<?php

namespace App\Http\Controllers\API;

use BD;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('permission:admin.index');
        $roles = Role::all();

        return response()->json([
            "roles" => $roles
        ], 200);
    }

    public function permissions($id)
    {
        $this->middleware('permission:admin.index');
        $permisos = \DB::table('permissions')
            ->leftJoin('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where('role_id', $id)
            ->get();

        return response()->json([
            "permissions" => $permisos
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->middleware('permission:admin.update');
        $role = Role::findOrFail($id);

        try {        
            $this->validate($request,[
                'name' => 'required|string|max:191',
                'guard_name' => 'required|string|max:191'
            ]);

            $role->update([
                'name' => $request['name'],
                'guard_name' => $request['guard_name']
            ]);

            $permissions = $request['permisosroles'];
            $role->syncPermissions($permissions);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error actualizando BD!'], 422);
        }

        return response()->json(['success' => 'Role actualizado exitosamente'], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->middleware('permission:admin.create');
        try {        
            $this->validate($request,[
                'name' => 'required|string|max:191'
            ]);

            $role = Role::create([
                'name' => $request['name'],
                'guard_name' => 'api'
            ]);

            if($permisos = $request['permisosroles']) {
                $role->givePermissionTo($permisos);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error creando el Role!'], 422);
        }

        return response()->json([
            "role" => $role
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->middleware('permission:admin.destroy');
        $permiso = Role::findOrFail($id);

        $permiso->delete();

        return response()->json(['success' => 'Role eliminado'], 201);
    }

    public function search(){
        $this->middleware('permission:admin.index');
        if ($search = \Request::get('q')) {
            $permisos = Role::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('guard_name','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $permisos = Permission::latest()->paginate(10);
        }
        return $permisos;
    }
}
