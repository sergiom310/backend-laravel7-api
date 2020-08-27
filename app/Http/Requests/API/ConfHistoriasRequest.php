<?php

namespace App\Http\Requests\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ConfHistoriasRequest extends FormRequest
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
            'clase_documento_id' => 'required|numeric',
            'anamnesis' => 'nullable|numeric',
            'rev_sistemas' => 'nullable|numeric',
            'ante_personales' => 'nullable|numeric',
            'ante_familiares' => 'nullable|numeric',
            'examen_fisico' => 'nullable|numeric',
            'analisis' => 'nullable|numeric',
            'diagnosticos' => 'nullable|numeric',
            'ordenes_medicas' => 'nullable|numeric',
            'plan' => 'nullable|numeric',
            'odontograma' => 'nullable|numeric',
            'estado_id' => 'required|numeric',
            'user_created_at' => 'required|numeric',
            'user_updated_at' => 'required|numeric',
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
            'clase_documento_id.required' => 'Clase documento es requerida',
            'anamnesis.numeric' => 'Anamnesis debe ser numerico',
            'rev_sistemas.numeric' => 'Rev sistemas debe ser numerico',
            'ante_personales.numeric' => 'Antecedentes personales debe ser numerico',
            'ante_familiares.numeric' => 'Antecedentes familiares debe ser numerico',
            'examen_fisico.numeric' => 'Examen_fisico debe ser numerico',
            'analisis.numeric' => 'Analisis debe ser numerico',
            'diagnosticos.numeric' => 'Diagnosticos debe ser numerico',
            'ordenes_medicas.numeric' => 'Ordenes medicas debe ser numerico',
            'plan.numeric' => 'Plan debe ser numerico',
            'odontograma.numeric' => 'Odontograma debe ser numerico',
            'estado_id.required' => 'Id estado es requerida',
            'estado_id.numeric' => 'Id estado debe ser numerico.',
            'user_created_at.required' => 'Id usuario created es requerida',
            'user_created_at.numeric' => 'Id usuario created debe ser numerico.',
            'user_updated_at.required' => 'Id usuario updated es requerida',
            'user_updated_at.numeric' => 'Id usuario updated debe ser numerico.'
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
