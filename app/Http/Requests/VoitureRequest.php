<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoitureRequest extends GenericRequest
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

         $voitureId = $this->route('voiture'); // Récupère l'ID de la Voiture pour la mise à jour (update)

        return [
            'marque' => ['required', 'string', 'max:255'],
            'plaque' => [
                'required',
                'string',
                'max:255',
                Rule::unique('voitures', 'plaque')
                    ->where('statut', 'actif')
                    ->ignore($voitureId),
            ],
        ];
    }


    public function messages(): array
    {
         return [
            'marque.required' => 'La marque est obligatoire.',
            'marque.string' => 'La marque doit être une chaîne de caractères.',
            'marque.max' => 'La marque ne peut pas dépasser 255 caractères.',

            'plaque.required' => 'La plaque est obligatoire.',
            'plaque.string' => 'La plaque doit être une chaîne de caractères.',
            'plaque.max' => 'La plaque ne peut pas dépasser 255 caractères.',
            'plaque.unique' => 'Cette plaque est déjà utilisée pour une voiture active.',
        ];

        
    }
}
