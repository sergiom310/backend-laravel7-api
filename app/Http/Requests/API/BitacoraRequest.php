<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ActividadesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'tipo_accion_id' => 'required|numeric',
            'fecha_actividad' => 'required|date',
            'des_actividad' => 'sometimes|string',
            'estado_id' => 'required|numeric',
            'clase_actividad' => 'required|numeric',
            'id_permiso_rol' => 'required|numeric'
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'Id usuario es requerida',
            'user_id.string' => 'Id usuario debe ser numerico.',
            'tipo_accion_id.required' => 'Id registro es requerida',
            'tipo_accion_id.numeric' => 'Id registro debe ser numerico.',
            'fecha_actividad.required' => 'Fecha actividad es requerida',
            'fecha_actividad.date' => 'Fecha actividad debe ser formato fecha',
            'estado_id.required' => 'Id estado es requerida',
            'estado_id.string' => 'Id estado debe ser numerico.',
            'clase_actividad.required' => 'Clase actividad es requerida',
            'clase_actividad.string' => 'Clase actividad debe ser numerico.',
            'id_permiso_rol.required' => 'Id permiso es requerida',
            'id_permiso_rol.string' => 'Id permiso debe ser numerico.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(['errors' => $errors], 422)
        );
    }
}
