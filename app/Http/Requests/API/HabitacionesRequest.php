<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class HabitacionesRequest extends FormRequest
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
            'nom_habitacion'     => 'required|max:50',
            'estado_id'          => 'required|numeric|exists:estados,id',
            'tipo_habitacion_id' => 'required|numeric|exists:tipo_habitacion,id'
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
            'nom_habitacion.required'     => ':attribute es requerida.',
            'nom_habitacion.max'          => ':attribute debe ser de máximo 50 carácteres.',
            'estado_id.required'          => ':attribute es requerida.',
            'estado_id.numeric'           => ':attribute debe ser númerico.',
            'estado_id.exists'            => ':attribute seleccionado no existe.',
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
