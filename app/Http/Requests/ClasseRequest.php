<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClasseRequest extends FormRequest
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

            'niveau_id' => ['required', 'exists:niveaux,id'],
            'cycle_id' => ['required', 'exists:cycles,id'],
            'libelle' => ['required', 'string', 'max:255'],

            'emplacement' => ['nullable', 'string'],
            'annee_id' => ['nullable', 'numeric'],


        ];
    }


    public function messages(): array
    {
         return [

          'niveau_id.required' => 'Le niveau est obligatoire.',
            'niveau_id.exists' => 'La classe  sélectionnée est invalide.',
            'cycle_id.required' => 'Le cycle est obligatoire.',
            'cycle_id.exists' => 'Le cycle sélectionné est invalide.',
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
        ];


    }
}
