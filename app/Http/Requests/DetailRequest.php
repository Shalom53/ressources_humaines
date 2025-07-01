<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DetailRequest extends GenericRequest
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

           'libelle' => ['required', 'string', 'max:255'],
            'paiement_id' => ['required', 'exists:paiements,id'],
            'inscription_id' => ['required', 'exists:inscriptions,id'],
            'type_paiement' => ['required', 'integer', 'between:0,255'],
            'montant' => ['required', 'numeric', 'min:0'],

        ];
    }


    public function messages(): array
    {
         return [
            
          'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne peut pas dépasser 255 caractères.',

            'paiement_id.required' => 'Le paiement est obligatoire.',
            'paiement_id.exists' => 'Le paiement sélectionné est invalide.',

            'inscription_id.required' => 'L\'inscription est obligatoire.',
            'inscription_id.exists' => 'L\'inscription sélectionnée est invalide.',

            'type_paiement.required' => 'Le type de paiement est obligatoire.',
            'type_paiement.integer' => 'Le type de paiement doit être un entier.',
            'type_paiement.between' => 'Le type de paiement doit être entre 0 et 255.',

            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être supérieur ou égal à 0.',
        ];


    }
}
