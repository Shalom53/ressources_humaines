<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompteRequest extends GenericRequest
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

        return [

           'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('comptes', 'email')->where(function ($query) {
                    return $query->where('statut', 'actif');
                }),
            ],
            'parent_id' => ['required', 'exists:parent_eleves,id'],


        ];
    }


    public function messages(): array
    {
         return [
            
          'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Le format de l\'adresse email est invalide.',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'parent_id.required' => 'Le parent est obligatoire.',
            'parent_id.exists' => 'Le parent sélectionné est invalide.',
        ];


    }
}
