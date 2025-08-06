<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaisseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'libelle' => 'required|string|max:255',
            'solde_initial' => 'nullable|numeric|min:0',
            'solde_final' => 'nullable|numeric|min:0',
            'date_ouverture' => 'nullable|date',
            'date_cloture' => 'nullable|date|after_or_equal:date_ouverture',
            'statut' => 'nullable|in:0,1,2', // Exemple : 0 = fermé, 1 = ouvert, 2 = clôturé
            'utilisateur_id' => 'nullable|exists:utilisateurs,id',
            'responsable_id' => 'nullable|exists:utilisateurs,id',
            'annee_id' => 'nullable|exists:annees,id',

        ];
    }

    public function messages(): array
    {
        return [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'solde_initial.numeric' => 'Le solde initial doit être un nombre.',
            'solde_final.numeric' => 'Le solde final doit être un nombre.',
            'date_ouverture.date' => 'La date d\'ouverture doit être une date valide.',
            'date_cloture.date' => 'La date de clôture doit être une date valide.',
            'date_cloture.after_or_equal' => 'La date de clôture doit être postérieure ou égale à la date d\'ouverture.',
            'statut.in' => 'Le statut est invalide.',
            'utilisateur_id.exists' => 'L\'utilisateur est invalide.',
            'responsable_id.exists' => 'Le responsable est invalide.',
            'annee_id.exists' => 'L\'année est invalide.',

        ];
    }
}
