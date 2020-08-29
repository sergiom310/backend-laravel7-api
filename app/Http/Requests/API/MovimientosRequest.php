<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class MovimientosRequest extends FormRequest
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
            'documento_id' => 'required|numeric|exists:documentos,id',
            'servicio_id' => 'required|numeric|exists:servicios,id',
            'valor_servicio' => 'required|numeric|min:1',
            'valor_total' => 'required|numeric|min:1',
            'cantidad' => 'required|numeric|min:1'
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
            'documento_id.required' => 'Id documento es requerido',
            'documento_id.numeric' => 'Id documento debe ser numerico.',
            'documento_id.exists' => 'Id documento suministrado No existe.',
            'servicio_id.required' => 'Id servicio es requerido',
            'servicio_id.numeric' => 'Id servicio debe ser numerico.',
            'servicio_id.exists' => 'Id servicio suministrado No existe.',
            'valor_servicio.required' => 'Valor servicio es requerido',
            'valor_servicio.numeric' => 'Valor servicio debe ser numerico.',
            'valor_total.required' => 'Valor total es requerido',
            'valor_total.numeric' => 'Valor total debe ser numerico.',
            'cantidad.required' => 'cantidad es requerida',
            'cantidad.numeric' => 'cantidad debe ser numerico.'
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
