<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClasseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // à personnaliser si tu veux restreindre l'accès
    }

    public function rules(): array
    {
        return [
            'libelle' => 'required|string|max:255',
            'emplacement' => 'nullable|string',
            'cycle_id' => 'nullable|exists:cycles,id',
            'niveau_id' => 'nullable|exists:niveaux,id',
            'annee_id' => 'nullable|exists:annees,id',

        ];
    }

    public function messages(): array
    {
        return [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne doit pas dépasser 255 caractères.',

            'emplacement.string' => 'L\'emplacement doit être une chaîne de caractères.',

            'cycle_id.exists' => 'Le cycle sélectionné est invalide.',
            'niveau_id.exists' => 'Le niveau sélectionné est invalide.',
            'annee_id.exists' => 'L\'année sélectionnée est invalide.',


        ];
    }
}
