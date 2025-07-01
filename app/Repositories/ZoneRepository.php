<?php

namespace App\Repositories;

use App\Models\Zone;
use App\Repositories\Interfaces\ZoneRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class ZoneRepository implements ZoneRepositoryInterface
{

    public function rechercheZoneById($id)
    {
        return Zone::findOrFail($id);
    }

    public function addZone(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Zone::create($data);
    }

    public function updateZone($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Zone = Zone::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Zone->update($merged);

        return $Zone;
    }

    public function deleteZone($id)
    {
        $Zone= Zone::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Zone) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Zone::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Zone::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
