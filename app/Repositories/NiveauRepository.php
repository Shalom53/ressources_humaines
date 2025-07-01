<?php

namespace App\Repositories;

use App\Models\Niveau;
use App\Repositories\Interfaces\NiveauRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class NiveauRepository implements NiveauRepositoryInterface
{

    public function rechercheNiveauById($id)
    {
        return Niveau::findOrFail($id);
    }

    public function addNiveau(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Niveau::create($data);
    }

    public function updateNiveau($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Niveau = Niveau::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [


            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Niveau->update($merged);

        return $Niveau;
    }

    public function deleteNiveau($id)
    {
        $Niveau= Niveau::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Niveau) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Niveau::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Niveau::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }

    public function getListeAvecTotalClasse(array $filters = [] )
    {
        $query = Niveau::withCount('classes')
            ->where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->get();
    }

}
