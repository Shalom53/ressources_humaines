<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProduitRequest extends GenericRequest
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

         $produitId = $this->route('id');

       return [
            'libelle' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produits', 'libelle')
                    ->where('statut', 'actif')
                    ->ignore($produitId),
            ],
        ];
    }


    public function messages(): array
    {
         return [
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne peut pas dépasser 255 caractères.',
            'libelle.unique' => 'Ce libellé est déjà utilisé pour un produit actif.',
        ];


    }
}
