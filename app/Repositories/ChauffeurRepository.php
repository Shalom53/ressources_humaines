<?php

namespace App\Repositories;

use App\Models\Chauffeur;
use App\Repositories\Interfaces\ChauffeurRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class ChauffeurRepository implements ChauffeurRepositoryInterface
{

    public function rechercheChauffeurById($id)
    {
        return Chauffeur::findOrFail($id);
    }

    public function addChauffeur(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Chauffeur::create($data);
    }

    public function updateChauffeur($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Chauffeur = Chauffeur::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Chauffeur->update($merged);

        return $Chauffeur;
    }

    public function deleteChauffeur($id)
    {
        $Chauffeur= Chauffeur::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Chauffeur) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Chauffeur::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Chauffeur::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
