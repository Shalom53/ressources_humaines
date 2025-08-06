<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FournisseurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'raison_social' => 'nullable|string|max:255|unique:fournisseurs,raison_social,' . $this->route('fournisseur'),
            'nom_contact' => 'nullable|string|max:150',
            'telephone_contact' => 'nullable|string|regex:/^(\+?\d{8,15})$/',
            'adresse' => 'nullable|string|max:1000',

        ];
    }

    public function messages(): array
    {
        return [
            'raison_social.string' => 'La raison sociale doit être une chaîne de caractères.',
            'raison_social.max' => 'La raison sociale ne peut pas dépasser 255 caractères.',
            'raison_social.unique' => 'Ce fournisseur existe déjà.',
            'nom_contact.string' => 'Le nom du contact doit être une chaîne de caractères.',
            'nom_contact.max' => 'Le nom du contact ne peut pas dépasser 150 caractères.',
            'telephone_contact.regex' => 'Le numéro de téléphone est invalide.',
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 1000 caractères.',

        ];
    }
}
