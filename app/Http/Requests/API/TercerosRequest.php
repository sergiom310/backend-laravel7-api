<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class TercerosRequest extends FormRequest
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
            'estado_id' => 'required|numeric',
            'tipo_identificacion' => 'required|numeric',
            'identificacion' => 'required',
            'nombres' => 'required',
            'user_created_at' => 'required|numeric',
            'user_updated_at' => 'required|numeric',
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
            'user_id.required' => 'Usuario Id es requerida',
            'user_id.numeric' => 'Usuario Id debe ser numerico.',
            'tipo_identificacion.required' => 'Tipo id es requerida',
            'tipo_identificacion.numeric' => 'Tipo id debe ser numerico',
            'identificacion.required' => 'Identificacion debe ser numerico.',
            'nombres.required' => 'Identificacion debe ser numerico.',
            'estado_id.required' => 'Id estado es requerida',
            'estado_id.numeric' => 'Id estado debe ser numerico.',
            'user_created_at.required' => 'Id usuario created es requerida',
            'user_created_at.numeric' => 'Id usuario created debe ser numerico.',
            'user_updated_at.required' => 'Id usuario updated es requerida',
            'user_updated_at.numeric' => 'Id usuario updated debe ser numerico.'
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
