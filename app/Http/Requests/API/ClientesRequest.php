<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ClientesRequest extends FormRequest
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
            'num_identificacion'              => 'required|string|max:20',
            'nom_cliente'                     => 'required|string|max:50',
            'tipo_identificacion_id'          => 'required|numeric|exists:tipo_identificacion,id',
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
            'num_identificacion.required'     => ':attribute es requerida.',
            'num_identificacion.max'          => ':attribute debe ser de máximo 20 carácteres.',
            'nom_cliente.required'            => ':attribute es requerida.',
            'nom_cliente.max'                 => ':attribute debe ser de máximo 50 carácteres.',
            'tipo_identificacion_id.required' => ':attribute es requerida.',
            'tipo_identificacion_id.numeric'  => ':attribute debe ser númerico.',
            'tipo_identificacion_id.exists'   => ':attribute seleccionado no existe.',
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
