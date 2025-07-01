<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CaisseRequest extends GenericRequest
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
            'libelle' => [
                'required',
                'string',
                'max:100',
                Rule::unique('caisses', 'libelle')
                    ->where('etat', 'ACTIF')
                    ->ignore($this->route('id')),
            ],
            'solde_initial' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }


    public function messages(): array
    {
         return [
            'libelle.required' => 'Le champ libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne peut pas dépasser 100 caractères.',
            'libelle.unique' => 'Une caisse active avec ce libellé existe déjà.',

            'solde_initial.required' => 'Le solde initial est obligatoire.',
            'solde_initial.numeric' => 'Le solde initial doit être un nombre.',
            'solde_initial.min' => 'Le solde initial doit être supérieur ou égal à 0.',
        ];

        
    }
}
