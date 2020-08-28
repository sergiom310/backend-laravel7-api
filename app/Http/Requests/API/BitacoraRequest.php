<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class BitacoraRequest extends FormRequest
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
        if ('POST' == $this->method) {        
            return [
                'tipo_accion_id' => 'required|numeric',
                'tabla_id' => 'required|numeric',
                'user_id' => 'required|numeric',
                'nom_tabla' => 'required|string',
                'obs_bitacora' => 'required|string'
            ];
        } else 
        {
            return [
                'tipo_accion_id' => 'sometimes|numeric',
                'tabla_id' => 'sometimes|numeric',
                'user_id' => 'sometimes|numeric',
                'nom_tabla' => 'sometimes|string',
                'obs_bitacora' => 'sometimes|string'
            ];
        }
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'tipo_accion_id.required' => 'Id registro es requerida',
            'tipo_accion_id.numeric' => 'Id registro debe ser numerico.',
            'tabla_id.required' => 'Id estado es requerida',
            'tabla_id.numeric' => 'Id estado debe ser numerico.',
            'user_id.required' => 'Id usuario es requerida',
            'user_id.numeric' => 'Id usuario debe ser numerico.'
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
