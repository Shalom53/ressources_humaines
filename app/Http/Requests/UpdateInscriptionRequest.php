<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInscriptionRequest extends FormRequest
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
            'classe_id' => ['required', 'exists:classes,id'],
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'date_naissance' => ['required'],
            'lieu_naissance' => ['required'],

            'sexe' => ['nullable'],
            'nationalite_id' => ['required','exists:nationalites,id'],


        ];
    }


    public function messages(): array
    {
        return [

            'niveau_id.required' => 'Le niveau est obligatoire.',
            'niveau_id.exists' => 'La classe  sélectionnée est invalide.',
            'cycle_id.required' => 'Le cycle est obligatoire.',
            'cycle_id.exists' => 'Le cycle sélectionné est invalide.',

            'classe_id.required' => 'La classe  est obligatoire.',
            'classe_id.exists' => 'La classe sélectionnée est invalide.',

            'nationalite_id.required' => 'La nationalite  est obligatoire.',
            'nationalite_id.exists' => 'La nationalite sélectionnée est invalide.',


            'nom.required' => 'Le nom  est obligatoire.',
            'nom.string' => 'Le nom  doit être une chaîne de caractères.',

            'prenom.required' => 'Le prenom  est obligatoire.',
            'prenom.string' => 'Le prenom  doit être une chaîne de caractères.',


            'date_naissance.required' => 'La date de naissance   est obligatoire.',
            'lieu_naissance.required' => 'Le lieu  de naissance   est obligatoire.',

        ];


    }
}
