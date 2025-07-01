<?php

namespace App\Repositories;

use App\Models\Eleve;
use App\Repositories\Interfaces\EleveRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class EleveRepository implements EleveRepositoryInterface
{

    public function rechercheEleveById($id)
    {
        return Eleve::findOrFail($id);
    }

    public function addEleve(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Eleve::create($data);
    }

    public function updateEleve($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Eleve = Eleve::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Eleve->update($merged);

        return $Eleve;
    }

    public function deleteEleve($id)
    {
        $Eleve= Eleve::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Eleve) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Eleve::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Eleve::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
