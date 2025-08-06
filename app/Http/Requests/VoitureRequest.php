<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoitureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'marque' => 'required|string|max:255',
            'plaque' => 'required|string|max:100',
            'nombre_place' => 'nullable|integer|min:1',
            'annee_id' => 'nullable|exists:annees,id',

        ];
    }

    public function messages(): array
    {
        return [
            'marque.required' => 'La marque est obligatoire.',
            'marque.string' => 'La marque doit être une chaîne de caractères.',
            'marque.max' => 'La marque ne doit pas dépasser 255 caractères.',

            'plaque.required' => 'La plaque est obligatoire.',
            'plaque.string' => 'La plaque doit être une chaîne de caractères.',
            'plaque.max' => 'La plaque ne doit pas dépasser 100 caractères.',

            'nombre_place.integer' => 'Le nombre de places doit être un entier.',
            'nombre_place.min' => 'Le nombre de places doit être au moins 1.',

            'annee_id.exists' => 'L\'année sélectionnée est invalide.',


        ];
    }
}
