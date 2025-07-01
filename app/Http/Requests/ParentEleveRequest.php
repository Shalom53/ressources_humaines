<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParentEleveRequest extends GenericRequest
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
          'nom_parent' => ['required', 'string', 'max:255'],
            'prenom_parent' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'regex:/^\+?[0-9]{7,15}$/'],
            'espace_id' => ['required', 'exists:espaces,id'],
        ];
    }


    public function messages(): array
    {
         return [
             'nom_parent.required' => 'Le nom du parent est obligatoire.',
            'nom_parent.string' => 'Le nom du parent doit être une chaîne de caractères.',
            'nom_parent.max' => 'Le nom du parent ne peut pas dépasser 255 caractères.',

            'prenom_parent.required' => 'Le prénom du parent est obligatoire.',
            'prenom_parent.string' => 'Le prénom du parent doit être une chaîne de caractères.',
            'prenom_parent.max' => 'Le prénom du parent ne peut pas dépasser 255 caractères.',

            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.regex' => 'Le numéro de téléphone doit être valide (7 à 15 chiffres, avec ou sans +).',

            'espace_id.required' => 'L\'espace est obligatoire.',
            'espace_id.exists' => 'L\'espace sélectionné est invalide.',
        ];

        
    }
}
