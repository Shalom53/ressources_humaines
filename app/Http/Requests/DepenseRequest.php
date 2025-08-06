<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // à adapter si tu veux restreindre l'accès
    }

    public function rules(): array
    {
        return [
            'libelle' => 'nullable|string|max:255',
            'beneficaire' => 'nullable|string|max:255',
            'motif_depense' => 'nullable|string',
            'date_depense' => 'nullable|date',
            'montant' => 'nullable|integer|min:0',

            'annee_id' => 'nullable|exists:annees,id',
            'utilisateur_id' => 'nullable|exists:utilisateurs,id',
            'centre_depense_id' => 'nullable|exists:centre_depenses,id',
            'ligne_budget_id' => 'nullable|exists:ligne_budgets,id',
            'budget_id' => 'nullable|exists:budgets,id',

            'statut_depense' => 'nullable|in:0,1,2', // Exemple: 0 = brouillon, 1 = validée, 2 = rejetée

        ];
    }

    public function messages(): array
    {
        return [
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'beneficaire.string' => 'Le bénéficiaire doit être une chaîne de caractères.',
            'motif_depense.string' => 'Le motif doit être une chaîne de caractères.',
            'date_depense.date' => 'La date de dépense doit être une date valide.',
            'montant.integer' => 'Le montant doit être un nombre entier.',
            'montant.min' => 'Le montant doit être positif.',

            'annee_id.exists' => "L'année spécifiée est invalide.",
            'utilisateur_id.exists' => "L'utilisateur spécifié est invalide.",
            'centre_depense_id.exists' => 'Le centre de dépense est invalide.',
            'ligne_budget_id.exists' => 'La ligne budgétaire est invalide.',
            'budget_id.exists' => 'Le budget est invalide.',

            'statut_depense.in' => 'Le statut est invalide.',

        ];
    }
}
