<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaiementRequest extends GenericRequest
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
          'payeur' => ['required', 'string', 'max:255'],
            'telephone_payeur' => ['required', 'regex:/^\+?[0-9]{7,15}$/'],
            'date_paiement' => ['required', 'date'],
            'mode_paiement' => ['required', 'integer', 'between:0,255'],
            'inscription_id' => ['required', 'exists:inscriptions,id'],
        ];
    }


    public function messages(): array
    {
         return [
            'payeur.required' => 'Le nom du payeur est obligatoire.',
            'payeur.string' => 'Le nom du payeur doit être une chaîne de caractères.',
            'payeur.max' => 'Le nom du payeur ne peut pas dépasser 255 caractères.',

            'telephone_payeur.required' => 'Le numéro de téléphone du payeur est obligatoire.',
            'telephone_payeur.regex' => 'Le numéro de téléphone doit être valide.',

            'date_paiement.required' => 'La date de paiement est obligatoire.',
            'date_paiement.date' => 'La date de paiement doit être une date valide.',

            'mode_paiement.required' => 'Le mode de paiement est obligatoire.',
            'mode_paiement.integer' => 'Le mode de paiement doit être un entier.',
            'mode_paiement.between' => 'Le mode de paiement doit être compris entre 0 et 255.',

            'inscription_id.required' => 'L\'inscription est obligatoire.',
            'inscription_id.exists' => 'L\'inscription sélectionnée est invalide.',
        ];


    }
}
