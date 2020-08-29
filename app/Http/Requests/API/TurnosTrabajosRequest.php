<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class TurnosTrabajosRequest extends FormRequest
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
            'estado_id' => 'required|numeric|exists:estados,id',
            'nom_turno_trabajo' => 'required|string|max:50',
            'hora_desde' => 'required|string|max:5',
            'hora_hasta' => 'required|string|max:5'
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
            'estado_id.required' => 'Id estado es requerido',
            'estado_id.numeric' => 'Id estado debe ser numerico.',
            'estado_id.exists' => 'Id estado suministrado No existe.',
            'nom_turno_trabajo.required' => 'Detalle turno es requerido',
            'nom_turno_trabajo.max' => 'Detalle turno debe ser máximo 50 caracteres.',
            'hora_desde.required' => 'Hora desde es requerida',
            'hora_desde.max' => 'Hora desde debe ser máximo 5 caracteres.',
            'hora_hasta.required' => 'Hora hasta es requerida',
            'hora_hasta.max' => 'Hora hasta debe ser máximo 5 caracteres.'
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
