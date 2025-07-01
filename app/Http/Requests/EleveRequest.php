<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EleveRequest extends GenericRequest
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

           'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'date_naissance' => ['required', 'date'],
            'lieu_naissance' => ['required', 'string', 'max:255'],
            'sexe' => ['required', 'integer', 'between:0,255'],
            'nationalite_id' => ['required', 'exists:nationalites,id'],
            'espace_id' => ['required', 'exists:espaces,id'],
        ];
    }


    public function messages(): array
    {
         return [
            
          'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',

            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',

            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',

            'lieu_naissance.required' => 'Le lieu de naissance est obligatoire.',
            'lieu_naissance.string' => 'Le lieu de naissance doit être une chaîne de caractères.',
            'lieu_naissance.max' => 'Le lieu de naissance ne peut pas dépasser 255 caractères.',

            'sexe.required' => 'Le sexe est obligatoire.',
            'sexe.integer' => 'Le sexe doit être un entier.',
            'sexe.between' => 'Le sexe doit être compris entre 0 et 255.',

            'nationalite_id.required' => 'La nationalité est obligatoire.',
            'nationalite_id.exists' => 'La nationalité sélectionnée est invalide.',

            'espace_id.required' => 'L\'espace est obligatoire.',
            'espace_id.exists' => 'L\'espace sélectionné est invalide.',
        ];


    }
}
