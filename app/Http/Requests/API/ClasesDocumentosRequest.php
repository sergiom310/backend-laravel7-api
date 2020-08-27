<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ClasesDocumentosRequest extends FormRequest
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
            'user_created_at' => 'required|numeric',
            'user_updated_at' => 'required|numeric',
            'modulo_id' => 'required|numeric',
            'cod_clase_documento' => 'required|string|max:4',
            'des_clase_documento' => 'required|string|max:45',
            'clase_dinamica' => 'sometimes|numeric',
            'sub_clase' => 'required|numeric',
            'tipo_historia' => 'required|numeric',
            'gen_consecutivo' => 'required|numeric',
            'consecutivo_id' => 'required|numeric',
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
            'estado_id.required' => 'Id estado es requerida',
            'estado_id.numeric' => 'Id estado debe ser numerico.',
            'user_created_at.required' => 'Id usuario es requerida',
            'user_created_at.numeric' => 'Id usuario debe ser numerico.',
            'user_updated_at.required' => 'Id usuario es requerida',
            'user_updated_at.numeric' => 'Id usuario debe ser numerico.',
            'modulo_id.required' => 'Id usuario es requerida',
            'modulo_id.numeric' => 'Id usuario debe ser numerico.',
            'cod_clase_documento.required' => 'Cod clase documento es requerida',
            'cod_clase_documento.string' => 'Cod clase documento debe ser texto.',
            'cod_clase_documento.max' => 'Cod clase documento debe ser maximo de 4 caracteres.',
            'des_clase_documento.required' => 'Cod clase documento es requerida',
            'des_clase_documento.string' => 'Cod clase documento debe ser texto.',
            'des_clase_documento.max' => 'Descripcion clase documento debe ser maximo de 45 caracteres.',
            'clase_dinamica.numeric' => 'Clase dinamica debe ser numerico.',
            'sub_clase.required' => 'Sub clase es requerida',
            'sub_clase.numeric' => 'Sub Clase debe ser numerico.',
            'tipo_historia.required' => 'Sub clase es requerida',
            'tipo_historia.numeric' => 'Sub Clase debe ser numerico.',
            'gen_consecutivo.required' => 'Genera consecutivo es requerida',
            'gen_consecutivo.numeric' => 'Genera consecutivo debe ser numerico.',
            'consecutivo_id.required' => 'Consecutivo es requerida',
            'consecutivo_id.numeric' => 'Consecutivo debe ser numerico.',
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
