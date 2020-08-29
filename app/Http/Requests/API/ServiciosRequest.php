<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ServiciosRequest extends FormRequest
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
                'nom_servicio'     => 'required|max:50',
                'tipo_servicio_id' => 'required|numeric|exists:tipo_servicio,id',
                'habitacion_id'    => 'required|numeric|exists:habitaciones,id'
            ];
        } else {
            return [
                'nom_servicio'     => 'required|max:50',
                'tipo_servicio_id' => 'required|numeric|exists:tipo_servicio,id',
                'habitacion_id'    => 'required|numeric|exists:habitaciones,id'
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
            'nom_servicio.required'     => ':attribute es requerido.',
            'nom_servicio.max'          => ':attribute debe ser de máximo 50 carácteres.',
            'tipo_servicio_id.required' => ':attribute es requerida.',
            'tipo_servicio_id.numeric'  => ':attribute debe ser númerico.',
            'tipo_servicio_id.exists'   => ':attribute seleccionado no existe.',
            'habitacion_id.required'    => ':attribute es requerida.',
            'habitacion_id.numeric'     => ':attribute debe ser númerico.',
            'habitacion_id.exists'      => ':attribute seleccionado no existe.',
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
