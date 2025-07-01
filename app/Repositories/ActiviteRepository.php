<?php

namespace App\Repositories;

use App\Models\Produit;
use App\Repositories\Interfaces\ActiviteRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class ActiviteRepository implements ActiviteRepositoryInterface
{

    public function rechercheActiviteById($id)
    {
        return Produit::findOrFail($id);
    }

    public function addActivite(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Produit::create($data);
    }

    public function updateActivite($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $activite = Produit::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [


            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $activite->update($merged);

        return $activite;
    }

    public function deleteActivite($id)
    {
        $activite= Produit::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($activite) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Produit::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Produit::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }



}
