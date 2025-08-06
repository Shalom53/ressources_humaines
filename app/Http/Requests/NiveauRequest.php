<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NiveauRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // à adapter si besoin de restrictions par utilisateur
    }

    public function rules(): array
    {
        return [
            'libelle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'numero_ordre' => 'nullable|integer|min:0',
            'cycle_id' => 'nullable|exists:cycles,id',

        ];
    }

    public function messages(): array
    {
        return [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne doit pas dépasser 255 caractères.',

            'description.string' => 'La description doit être une chaîne de caractères.',

            'numero_ordre.integer' => 'Le numéro d\'ordre doit être un entier.',
            'numero_ordre.min' => 'Le numéro d\'ordre doit être supérieur ou égal à 0.',

            'cycle_id.exists' => 'Le cycle sélectionné est invalide.',

        ];
    }
}
