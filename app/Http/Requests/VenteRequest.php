<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date_vente' => 'nullable|date',
            'quantite' => 'nullable|numeric|min:0.01',

            'annee_id' => 'nullable|exists:annees,id',
            'inscription_id' => 'nullable|exists:inscriptions,id',
            'paiement_id' => 'nullable|exists:paiements,id',
            'produit_id' => 'nullable|exists:produits,id',
            'detail_id' => 'nullable|exists:details,id',
            'utilisateur_id' => 'nullable|exists:utilisateurs,id',


        ];
    }

    public function messages(): array
    {
        return [
            'date_vente.date' => 'La date de vente doit être une date valide.',
            'quantite.numeric' => 'La quantité doit être un nombre.',
            'quantite.min' => 'La quantité doit être supérieure à 0.',

            'annee_id.exists' => 'L\'année sélectionnée est invalide.',
            'inscription_id.exists' => 'L\'inscription sélectionnée est invalide.',
            'paiement_id.exists' => 'Le paiement sélectionné est invalide.',
            'produit_id.exists' => 'Le produit sélectionné est invalide.',
            'detail_id.exists' => 'Le détail sélectionné est invalide.',
            'utilisateur_id.exists' => 'L\'utilisateur sélectionné est invalide.',


        ];
    }
}
