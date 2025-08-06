<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UtilisateurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Si c’est une modification, on ignore l’email/login de l’utilisateur courant
        $id = $this->route('utilisateur')?->id;

        return [
            'nom' => 'nullable|string|max:100',
            'prenom' => 'nullable|string|max:100',
            'login' => 'nullable|string|max:100|unique:utilisateurs,login,' . $id,
            'email' => 'nullable|email|max:150|unique:utilisateurs,email,' . $id,
            'mot_passe' => $id ? 'nullable|string|min:6' : 'required|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'nullable|integer|in:0,1,2,3', // adapter selon la définition de tes rôles

        ];
    }

    public function messages(): array
    {
        return [
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'login.unique' => 'Ce login est déjà utilisé.',
            'email.email' => 'L\'adresse email est invalide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'mot_passe.required' => 'Le mot de passe est requis.',
            'mot_passe.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.mimes' => 'L\'image doit être de type jpeg, png, jpg ou gif.',
            'photo.max' => 'La taille maximale de la photo est de 2 Mo.',
            'role.in' => 'Le rôle est invalide.',

        ];
    }
}
