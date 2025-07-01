<?php

namespace App\Repositories;

use App\Models\ParentEleve;
use App\Repositories\Interfaces\ParentEleveRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class ParentEleveRepository implements ParentEleveRepositoryInterface
{

    public function rechercheParentEleveById($id)
    {
        return ParentEleve::findOrFail($id);
    }

    public function addParentEleve(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return ParentEleve::create($data);
    }

    public function updateParentEleve($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $ParentEleve = ParentEleve::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $ParentEleve->update($merged);

        return $ParentEleve;
    }

    public function deleteParentEleve($id)
    {
        $ParentEleve= ParentEleve::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($ParentEleve) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = ParentEleve::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = ParentEleve::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
