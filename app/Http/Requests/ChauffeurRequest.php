<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChauffeurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // à adapter si tu as un système de permissions
    }

    public function rules(): array
    {
        return [
            'nom' => 'nullable|string|max:100',
            'prenom' => 'nullable|string|max:100',
            'telephone' => 'nullable|string|regex:/^(\+?\d{8,15})$/',
            'annee_id' => 'nullable|exists:annees,id',

        ];
    }

    public function messages(): array
    {
        return [
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'telephone.regex' => 'Le numéro de téléphone est invalide.',
            'annee_id.exists' => "L'année sélectionnée est invalide.",

        ];
    }
}
