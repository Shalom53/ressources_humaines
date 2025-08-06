<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'libelle' => 'nullable|string|max:255|unique:zones,libelle,' . $this->route('zone'),
            'description' => 'nullable|string|max:1000',

            'chauffeur_id' => 'nullable|exists:chauffeurs,id',
            'voiture_id' => 'nullable|exists:voitures,id',
            'annee_id' => 'nullable|exists:annees,id',


        ];
    }

    public function messages(): array
    {
        return [
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne peut pas dépasser 255 caractères.',
            'libelle.unique' => 'Une zone avec ce libellé existe déjà.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',

            'chauffeur_id.exists' => 'Le chauffeur sélectionné est invalide.',
            'voiture_id.exists' => 'La voiture sélectionnée est invalide.',
            'annee_id.exists' => 'L\'année sélectionnée est invalide.',


        ];
    }
}
