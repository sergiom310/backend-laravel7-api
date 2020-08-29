<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ReservacionesRequest extends FormRequest
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
            'check_in'      => 'required|date',
            'check_out'     => 'required|date',
            'id_cliente'    => 'required|numeric|exists:clientes,id',
            'id_habitacion' => 'required|numeric|exists:habitaciones,id',
            'id_estado'     => 'required|numeric|exists:estados,id',
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
            'check_in.required'           => ':attribute es requerida.',
            'check_in.required'           => ':attribute es requerida.',
            'id_cliente.required'         => ':attribute es requerida.',
            'id_cliente.numeric'          => ':attribute debe ser númerico.',
            'id_cliente.exists'           => ':attribute seleccionado no existe.',
            'tipo_habitacion_id.required' => ':attribute es requerida.',
            'tipo_habitacion_id.numeric'  => ':attribute debe ser númerico.',
            'tipo_habitacion_id.exists'   => ':attribute seleccionado no existe.',
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
