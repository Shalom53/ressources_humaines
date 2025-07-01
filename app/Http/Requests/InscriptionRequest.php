<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InscriptionRequest extends GenericRequest
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

           'date_inscription' => ['required', 'date'],
            'eleve_id' => ['required', 'exists:eleves,id'],
            'cycle_id' => ['required', 'exists:cycles,id'],
            'niveau_id' => ['required', 'exists:niveaux,id'],
            'sexe' => ['required', 'integer', 'between:0,255'],
            'parent_id' => ['required', 'exists:parent_Inscriptions,id'],
            'type_inscription' => ['required', 'integer', 'between:0,255'],
            'frais_scolarite' => ['required', 'numeric', 'min:0'],
        ];
    }


    public function messages(): array
    {
         return [
            
          'date_inscription.required' => 'La date d\'inscription est obligatoire.',
            'date_inscription.date' => 'La date d\'inscription doit être une date valide.',

            'eleve_id.required' => 'L\'élève est obligatoire.',
            'eleve_id.exists' => 'L\'élève sélectionné est invalide.',

            'cycle_id.required' => 'Le cycle est obligatoire.',
            'cycle_id.exists' => 'Le cycle sélectionné est invalide.',

            'niveau_id.required' => 'Le niveau est obligatoire.',
            'niveau_id.exists' => 'Le niveau sélectionné est invalide.',

            'sexe.required' => 'Le sexe est obligatoire.',
            'sexe.integer' => 'Le sexe doit être un entier.',
            'sexe.between' => 'Le sexe doit être compris entre 0 et 255.',

            'parent_id.required' => 'Le parent est obligatoire.',
            'parent_id.exists' => 'Le parent sélectionné est invalide.',

            'type_inscription.required' => 'Le type d\'inscription est obligatoire.',
            'type_inscription.integer' => 'Le type d\'inscription doit être un entier.',
            'type_inscription.between' => 'Le type d\'inscription doit être compris entre 0 et 255.',

            'frais_scolarite.required' => 'Le montant des frais de scolarité est obligatoire.',
            'frais_scolarite.numeric' => 'Les frais de scolarité doivent être un nombre.',
            'frais_scolarite.min' => 'Les frais de scolarité doivent être supérieurs ou égaux à 0.',
        ];


    }
}
