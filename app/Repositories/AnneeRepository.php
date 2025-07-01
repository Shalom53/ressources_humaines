<?php

namespace App\Repositories;

use App\Models\Annee;
use App\Repositories\Interfaces\AnneeRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class AnneeRepository implements AnneeRepositoryInterface
{

    public function rechercheAnneeById($id)
    {
        return Annee::findOrFail($id);
    }

    public function addAnnee(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Annee::create($data);
    }

    public function updateAnnee($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $annee = Annee::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [


            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $annee->update($merged);

        return $annee;
    }

    public function deleteAnnee($id)
    {
        $annee= Annee::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($annee) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Annee::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Annee::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }



}
