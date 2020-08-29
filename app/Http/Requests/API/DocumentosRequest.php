<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class DocumentosRequest extends FormRequest
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
            'tipo_documento_id' => 'required|numeric|exists:tipo_documento,id',
            'reservaciones_id' => 'required|numeric|exists:reservaciones,id',
            'turno_trabajo_id' => 'required|numeric|exists:turnos_trabajos,id',
            'impuestos' => 'sometimes|numeric',
            'valor_total' => 'required|numeric|min:1',
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
            'tipo_documento_id.required' => 'Id tipo documento es requerido',
            'tipo_documento_id.numeric' => 'Id tipo documento debe ser numerico.',
            'tipo_documento_id.exists' => 'Id tipo documento suministrado No existe.',
            'reservaciones_id.required' => 'Id reservación es requerido',
            'reservaciones_id.numeric' => 'Id reservación debe ser numerico.',
            'reservaciones_id.exists' => 'Id reservación suministrado No existe.',
            'turno_trabajo_id.required' => 'Id turno trabajo es requerido',
            'turno_trabajo_id.numeric' => 'Id turno trabajo debe ser numerico.',
            'turno_trabajo_id.exists' => 'Id turno trabajo suministrado No existe.',
            'impuestos.required' => 'Impuestos es requerido',
            'impuestos.numeric' => 'Impuestos debe ser numerico.',
            'valor_total.required' => 'Valor total es requerido',
            'valor_total.numeric' => 'Valor total debe ser numerico.',
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
