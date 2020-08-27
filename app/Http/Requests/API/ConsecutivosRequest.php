<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ConsecutivosRequest extends FormRequest
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
            'estado_id' => 'required|numeric',
            'prefijo' => 'required|string',
            'consecutivo' => 'required|numeric',
            'consecutivo_desde' => 'required|numeric',
            'consecutivo_hasta' => 'required|numeric',
            'consecutivo_alerta' => 'required|numeric',
            'consecutivo_vct' => 'sometimes',
            'des_consecutivo' => 'sometimes|string',
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
            'prefijo.required' => 'prefijo es requerido',
            'prefijo.string' => 'prefijo debe ser string.',
            'estado_id.required' => 'Id estado es requerida',
            'estado_id.numeric' => 'Id estado debe ser numerico.'
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
