<?php

namespace App\Http\Requests;

use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BanqueRequest extends GenericRequest
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
            'nom' => [
                'required',
                'string',
                'max:100',
                Rule::unique('banques', 'nom')
                    ->where('etat', TypeStatus::ACTIF)
                    ->ignore($this->route('id')), // utile en update
            ],
        ];
    }


    public function messages(): array
    {
         return [
            'nom.required' => 'Le champ nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne peut pas dépasser 100 caractères.',
            'nom.unique' => 'Une banque active avec ce nom existe déjà.',
        ];


    }
}
