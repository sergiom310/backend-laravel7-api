<?php

namespace App\Http\Controllers\API;

use BD;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\API\UsersRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
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
        $users = \DB::table('users')
            ->leftjoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftjoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->selectRaw(
                "users.id,
                users.name,
                username,
                email,
                email_verified_at,
                tipo_documento,
                documento,
                phone,
                mobile,
                address,
                CASE WHEN email_verified_at IS NOT NULL THEN 'Activo' ELSE 'Inactivo' END AS activo,
                users.created_at,
                role_id,
                roles.name AS role_name
                ")
            ->get();

        return response()->json([
            "users" => $users
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function roles()
    {
        $this->middleware('permission:admin.index');
        $roles = \DB::table('roles')->select('id','name')->get();
        return response()->json(['data' => $roles], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        $this->middleware('permission:admin.create');
        try {        
            $request->merge(['activation_code' => Str::random(30).time()]);
            $request->merge(['email_verified_at' => Carbon::now()]);

            if(!empty($request->password)){
                $request->merge(['password' => Hash::make($request['password'])]);
            }

            $user = User::create($request->all());

            $user->assignRole($request->role_id);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error creando el Usuario!'], 422);
        }

        return response()->json([
            "user" => $user
        ], 201);
    }

    public function updateProfile(Request $request)
    {
        $this->middleware('permission:admin.update');
        $user = auth('api')->user();

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'username' => 'required|string|max:190|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:8'
        ]);

        $currentPhoto = $user->photo;

        if($request->photo != $currentPhoto) {
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];       

            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);

            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message' => 'Uploaded Success!'];
    }

    public function profile()
    {
        $this->middleware('permission:admin.index');
        return response()->json([
            "user" => auth('api')->user()
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->middleware('permission:admin.index');
        return $this.profile;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, $id)
    {
        $this->middleware('permission:admin.update');
        $user = User::findOrFail($id);

        try {
            if(!empty($request->password)){
                $request->merge(['password' => Hash::make($request['password'])]);
            }

            if(!$user->hasRole($request['role_id'])) {
                $user->syncRoles($request['role_id']);
            } else {
                $user->assignRole($request['role_id']);
            }

            $user->update($request->all());
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error actualizando el usuario'], 422);
        }

        return response()->json(['success' => 'Usuario actualizado exitosamente'], 201);
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
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json(['success' => 'Usuario eliminado'], 201);
    }

    /**
     * Activate the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request, $id)
    {
        $this->middleware('permission:admin.update');
        $user = User::findOrFail($id);
        if ($request['estado'] == 'Activar') {
            $status = 'Activado';
            $estado = Carbon::now();
        } else {
            $estado = null;
            $status = 'Inactivo';
        }

        $user->update([
            'email_verified_at' => $estado
        ]);

        return response()->json(['success' => 'Usuario ' . $status], 201);
    }

    public function search(){
        $this->middleware('permission:admin.index');
        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%")
                        ->orWhere('username','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $users = User::latest()->paginate(5);
        }
        return $users;
    }
}
