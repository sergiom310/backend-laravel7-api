<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class DefinicionesRequest extends FormRequest
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
            'tipo_definicion_id' => 'required|numeric',
            'cod_definicion' => 'required|string|max:5',
            'des_definicion' => 'nullable|max:100',
            'val_definicion' => 'nullable',
            'conf_definicion' => 'nullable',
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
            'tipo_definicion_id.required' => 'Tipo definicion es requerida',
            'tipo_definicion_id.numeric' => 'Tipo definicion debe ser numerico.',
            'cod_definicion.required' => 'Cod definicion es requerida',
            'cod_definicion.max' => 'Cod definicion longitud maximo 5 caracteres.',
            'des_definicion.max' => 'Descripcion definicion longitud maximo 100 caracteres'
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
