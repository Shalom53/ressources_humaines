<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUtilisateurRequest extends FormRequest
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
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'login' => [
                'required', 'string', 'max:100',
                function ($attribute, $value, $fail) {
                    $exists = User::where('login', $value)
                        ->where('etat', TypeStatus::ACTIF)
                        ->exists();
                    if ($exists) {
                        $fail('Ce login est déjà utilisé par un utilisateur actif.');
                    }
                }
            ],
            'mot_passe' => ['required', 'string', 'min:6' ],
            'photo' => ['nullable', 'max:2048', 'image'],
            'role' => ['required'],
        ];
    }


    public function messages(): array
    {
         return [
             'nom.required' => 'Le nom est obligatoire.',
             'prenom.required' => 'Le prénom est obligatoire.',
             'role.required' => 'Le role  est obligatoire.',
             'login.required' => 'Le login est requis.',
             'mot_passe.required' => 'Le mot de passe est requis.',
             'mot_passe.min' => 'Le mot de passe doit contenir au moins 6 caractères.',

             'photo.image' => 'Le fichier photo doit être une image.',
             'photo.max' => 'La photo ne doit pas dépasser 2 Mo.',
        ];


    }
}
