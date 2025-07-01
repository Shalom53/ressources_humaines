<?php

namespace App\Repositories;

use App\Models\Detail;
use App\Repositories\Interfaces\DetailRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class DetailRepository implements DetailRepositoryInterface
{

    public function rechercheDetailById($id)
    {
        return Detail::findOrFail($id);
    }

    public function addDetail(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Detail::create($data);
    }

    public function updateDetail($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Detail = Detail::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Detail->update($merged);

        return $Detail;
    }

    public function deleteDetail($id)
    {
        $Detail= Detail::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Detail) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Detail::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Detail::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
