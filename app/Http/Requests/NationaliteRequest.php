<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NationaliteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'libelle' => 'nullable|string|max:100|unique:nationalites,libelle,' . $this->route('nationalite'),

        ];
    }

    public function messages(): array
    {
        return [
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne peut pas dépasser 100 caractères.',
            'libelle.unique' => 'Cette nationalité existe déjà.',

        ];
    }
}
