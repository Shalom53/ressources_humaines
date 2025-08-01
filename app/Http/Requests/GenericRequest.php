<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenericRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'libelle'   => ['required', 'string', 'max:100'],
            //
        ];
    }


    /**
     * Messages d'erreur personnalisés.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'libelle.required'   => 'Le libelle est obligatoire.',
            'libelle.string'    => 'Le libelle doit être une chaîne de caractères.',
            'libelle.max'       => 'Le libelle ne peut pas dépasser 100 caractères.',
        ];
    }
}
