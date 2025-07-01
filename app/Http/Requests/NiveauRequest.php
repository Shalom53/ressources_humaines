<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NiveauRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $niveauId = $this->route('id');
        return [
          'libelle' => [
                'required',
                'string',
                'max:255',
                Rule::unique('niveaux', 'libelle')
                    ->where('etat', TypeStatus::ACTIF)
                    ->ignore($niveauId),
            ],
            'cycle_id' => ['required', 'exists:cycles,id'],
            'description' => ['nullable', 'string'],
            'numero_ordre' => ['nullable', 'numeric'],
        ];
    }


    public function messages(): array
    {
         return [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne peut pas dépasser 255 caractères.',
            'libelle.unique' => 'Ce libellé est déjà utilisé pour un niveau actif.',

            'cycle_id.required' => 'Le cycle est obligatoire.',
            'cycle_id.exists' => 'Le cycle sélectionné est invalide.',
        ];


    }
}
