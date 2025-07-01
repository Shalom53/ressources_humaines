<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnneeRequest extends GenericRequest
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


        $anneeId = $this->route('id');

        return [
            'libelle' => [
                'required',
                'string',
                'max:100',
                Rule::unique('annees', 'libelle')
                    ->where('etat', TypeStatus::ACTIF)
                    ->ignore($anneeId),
            ],

            'date_rentree' => ['nullable'],
            'date_fin' => ['nullable'],
            'date_ouverture_inscription' => ['nullable'],
            'date_fermeture_reinscription' => ['nullable'],
            'statut_annee' => ['nullable'],





        ];
    }


    public function messages(): array
    {
         return [
            'libelle.required' => 'Le champ libelle est obligatoire.',
            'libelle.string' => 'Le libelle doit être une chaîne de caractères.',
            'libelle.max' => 'Le libelle ne peut pas dépasser 100 caractères.',
            'libelle.unique' => 'Une année  active avec ce libelle existe déjà.',
        ];


    }
}
