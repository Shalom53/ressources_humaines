<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UtilisateurRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UtilisateurRepository implements UtilisateurRepositoryInterface
{

    public function rechercheUtilisateurById($id)
    {
        return User::findOrFail($id);
    }

    public function addUtilisateur(array $data)
    {
        // Vérifier que le login est unique parmi les utilisateurs actifs
        $existe = User::where('login', $data['login'])
            ->where('etat', TypeStatus::ACTIF)
            ->exists();

        if ($existe) {
            throw new \Exception('Ce login est déjà utilisé pour un utilisateur actif.');
        }

        $utilisateur = new User();
        $utilisateur->nom = $data['nom'];
        $utilisateur->prenom = $data['prenom'];
        $utilisateur->login = $data['login'];
        $utilisateur->role = $data['role'];
        $utilisateur->mot_passe = Hash::make($data['mot_passe']);
        $utilisateur->photo = $data['photo'] ?? null;

        $utilisateur->save();

        return $utilisateur;
    }

    public function updateUtilisateur($id, array $data)
    {
        $utilisateur = User::find($id);
        if (!$utilisateur) {
            return null;
        }

        // Vérifier que le login est toujours unique pour les autres utilisateurs actifs
        if (isset($donnees['login'])) {
            $existe = User::where('login', $donnees['login'])
                ->where('etat', TypeStatus::ACTIF)
                ->where('id', '!=', $id)
                ->exists();

            if ($existe) {
                throw new \Exception('Ce login est déjà utilisé pour un autre utilisateur actif.');
            }

            $utilisateur->login = $donnees['login'];
        }

        $utilisateur->nom = $donnees['nom'] ?? $utilisateur->nom;
        $utilisateur->prenom = $donnees['prenom'] ?? $utilisateur->prenom;

        if (!empty($donnees['mot_passe'])) {
            $utilisateur->mot_passe = Hash::make($donnees['mot_passe']);
        }

        if (isset($donnees['photo'])) {
            $utilisateur->photo = $donnees['photo'];
        }


        if (isset($donnees['role'])) {
            $utilisateur->role = $donnees['role'];
        }



        $utilisateur->save();

        return $utilisateur;
    }

    public function deleteUtilisateur($id)
    {
        $Utilisateur= User::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Utilisateur) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = User::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = User::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }

    public function verifierIdentifiants(string $login, string $mot_passe): ?User
    {
        $utilisateur = User::where('login', $login)
            ->where('etat', TypeStatus::ACTIF)
            ->first();

        if ($utilisateur && Hash::check($mot_passe, $utilisateur->mot_passe)) {
            return $utilisateur;
        }

        return null;
    }
}
