<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Types\TypeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends GenericRequest
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
            'login' => ['required', 'string'],
            'mot_passe' => ['required', 'string'],

        ];
    }


    public function messages(): array
    {
         return [

             'login.required' => 'Veuillez saisir votre identifiant de connexion.',
             'login.string' => 'Le login doit être une chaîne de caractères valide.',
             'mot_passe.required' => 'Veuillez saisir votre mot de passe.',
             'mot_passe.string' => 'Le mot de passe doit être une chaîne de caractères.',
        ];


    }
}
