<?php

namespace App\Repositories;

use App\Models\Compte;
use App\Repositories\Interfaces\CompteRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class CompteRepository implements CompteRepositoryInterface
{

    public function rechercheCompteById($id)
    {
        return Compte::findOrFail($id);
    }

    public function addCompte(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Compte::create($data);
    }

    public function updateCompte($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Compte = Compte::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Compte->update($merged);

        return $Compte;
    }

    public function deleteCompte($id)
    {
        $Compte= Compte::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Compte) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Compte::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Compte::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
