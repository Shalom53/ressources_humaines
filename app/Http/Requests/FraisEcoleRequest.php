<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FraisEcoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'libelle' => 'nullable|string|max:255',
            'montant' => 'nullable|numeric|min:0',

            'type_paiement' => 'nullable|in:0,1,2', // À adapter selon les types définis (ex : 0 = unique, 1 = mensualisé, etc.)
            'type_forfait' => 'nullable|in:0,1,2',  // Idem pour les forfaits (ex : 0 = fixe, 1 = variable…)

            'niveau_id' => 'nullable|exists:niveaux,id',
            'annee_id' => 'nullable|exists:annees,id',

            'type_produit' => 'nullable|in:0,1,2', // ex : 0 = scolaire, 1 = cantine, 2 = bus…
            'prix_min' => 'nullable|integer|min:0|lte:prix_max',
            'prix_max' => 'nullable|integer|min:0|gte:prix_min',


        ];
    }

    public function messages(): array
    {
        return [
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être supérieur ou égal à 0.',

            'type_paiement.in' => 'Le type de paiement est invalide.',
            'type_forfait.in' => 'Le type de forfait est invalide.',
            'type_produit.in' => 'Le type de produit est invalide.',

            'niveau_id.exists' => 'Le niveau sélectionné est invalide.',
            'annee_id.exists' => 'L\'année sélectionnée est invalide.',

            'prix_min.integer' => 'Le prix minimum doit être un nombre entier.',
            'prix_min.min' => 'Le prix minimum doit être au moins 0.',
            'prix_min.lte' => 'Le prix minimum doit être inférieur ou égal au prix maximum.',
            'prix_max.integer' => 'Le prix maximum doit être un nombre entier.',
            'prix_max.gte' => 'Le prix maximum doit être supérieur ou égal au prix minimum.',

        ];
    }
}
