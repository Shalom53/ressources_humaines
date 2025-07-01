<?php

namespace App\Repositories;

use App\Models\Caisse;
use App\Repositories\Interfaces\CaisseRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class CaisseRepository implements CaisseRepositoryInterface
{

    public function rechercheCaisseById($id)
    {
        return Caisse::findOrFail($id);
    }

    public function addCaisse(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Caisse::create($data);
    }

    public function updateCaisse($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Caisse = Caisse::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Caisse->update($merged);

        return $Caisse;
    }

    public function deleteCaisse($id)
    {
        $Caisse= Caisse::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Caisse) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Caisse::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Caisse::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
