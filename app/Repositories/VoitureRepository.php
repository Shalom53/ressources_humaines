<?php

namespace App\Repositories;

use App\Models\Voiture;
use App\Repositories\Interfaces\VoitureRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class VoitureRepository implements VoitureRepositoryInterface
{

    public function rechercheVoitureById($id)
    {
        return Voiture::findOrFail($id);
    }

    public function addVoiture(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Voiture::create($data);
    }

    public function updateVoiture($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Voiture = Voiture::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Voiture->update($merged);

        return $Voiture;
    }

    public function deleteVoiture($id)
    {
        $Voiture= Voiture::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Voiture) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Voiture::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Voiture::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
