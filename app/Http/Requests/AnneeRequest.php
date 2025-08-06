<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnneeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autorise toutes les requêtes, à adapter selon ta logique
    }

    public function rules(): array
    {
        return [
            'libelle' => 'required|string|max:255',
            'date_rentree' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_rentree',
            'date_ouverture_inscription' => 'nullable|date',
            'date_fermeture_reinscription' => 'nullable|date|after_or_equal:date_ouverture_inscription',
            'statut_annee' => 'nullable|in:0,1', // exemple : 0 = inactif, 1 = actif

        ];
    }

    public function messages(): array
    {
        return [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'date_rentree.required' => 'La date de rentrée est obligatoire.',
            'date_rentree.date' => 'La date de rentrée doit être une date valide.',
            'date_fin.required' => 'La date de fin est obligatoire.',
            'date_fin.date' => 'La date de fin doit être une date valide.',
            'date_fin.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de rentrée.',
            'date_fermeture_reinscription.after_or_equal' => 'La fermeture des réinscriptions doit être après l’ouverture.',
            'statut_annee.in' => 'Le statut doit être 0 ou 1.',

        ];
    }
}
