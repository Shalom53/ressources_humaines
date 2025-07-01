<?php

namespace App\Repositories;

use App\Models\Cycle;
use App\Repositories\Interfaces\CycleRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class CycleRepository implements CycleRepositoryInterface
{

    public function rechercheCycleById($id)
    {
        return Cycle::findOrFail($id);
    }

    public function addCycle(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Cycle::create($data);
    }

    public function updateCycle($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $cycle = Cycle::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
           

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $cycle->update($merged);

        return $cycle;
    }

    public function deleteCycle($id)
    {
        $cycle= Cycle::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($cycle) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Cycle::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Cycle::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    public function getListeAvecTotalNiveau(array $filters = [] )
    {
        $query = Cycle::withCount('niveaux')
            ->where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->get();
    }
}
