<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrancheRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'libelle' => 'nullable|string|max:255',
            'date_butoire' => 'nullable|date',
            'frais_ecole_id' => 'nullable|exists:frais_ecoles,id',
            'type_frais' => 'nullable|in:0,1,2', // Adapter selon ton système (ex: 0 = scolarité, 1 = cantine, etc.)
            'taux' => 'nullable|integer|min:0|max:100',

        ];
    }

    public function messages(): array
    {
        return [
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'date_butoire.date' => 'La date butoire doit être une date valide.',
            'frais_ecole_id.exists' => 'Le frais d\'école sélectionné est invalide.',
            'type_frais.in' => 'Le type de frais est invalide.',
            'taux.integer' => 'Le taux doit être un nombre entier.',
            'taux.min' => 'Le taux ne peut pas être inférieur à 0.',
            'taux.max' => 'Le taux ne peut pas dépasser 100.',

        ];
    }
}
