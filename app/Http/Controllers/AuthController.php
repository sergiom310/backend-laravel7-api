<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Services\CustomPasswordBrokerManager;
use App\Notifications\UserRegisteredSuccessfully;
use Spatie\Permission\Models\Role;
use App\Http\Requests;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Create users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserStoreRequest $request)
    {
        /** @var User $user */
        $validatedData = $request->validated();

        try {
            $validatedData['password']        = bcrypt(Arr::get($validatedData, 'password'));
            $validatedData['activation_code'] = Str::random(30).time();
            $validatedData['photo']           = null;
            $user                             = User::create($validatedData);
            
            // * si no viene el role, asignamos Role = "Usuario" que es role de usuario normal por defecto *
            DB::table('model_has_roles')->insert([
                'role_id' => 3,
                'model_type' => 'App\User',
                'model_id' => $user->id
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error creando el usuario API'], 422);
        }

        $user->notify(new UserRegisteredSuccessfully($user));
        return response()->json(['success' => $user], 201);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $recaptchaSiteKey = request('recaptchaToken');
        if (trim($recaptchaSiteKey)) {
            $recaptchaSecret = "6LdLMzgUAAAAAEs_42BvtJiTWpGOYw0L1UmhsJDa";
            $apiCall = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaSiteKey";
            $response = file_get_contents($apiCall);
            $responseKeys = json_decode($response, true);
            if(intval($responseKeys["success"]) !== 1) {
                return response()->json(['error' => 'Recaptcha no valido'], 401);
            }
        }

        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Email o contraseña incorrectas'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = $this->guard()->user();
        $permisos = $user->getAllPermissions();
        $role = \DB::table('model_has_roles')
            ->select('role_id','name')
            ->where('model_id','=',$user->id)
            ->join('roles','model_has_roles.role_id', '=', 'roles.id')
            ->first();
        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'ttl' =>  auth('api')->factory()->getTTL(),
            'permission' => $permisos,
            'roleuser' => ['id' => $role->role_id,'role' => $role->name],
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 280
        ]);
    }

    public function guard() {
        return \Auth::Guard('api');
    }
}
