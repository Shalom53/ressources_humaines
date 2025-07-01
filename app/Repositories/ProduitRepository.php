<?php

namespace App\Repositories;

use App\Models\Produit;
use App\Repositories\Interfaces\ProduitRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class ProduitRepository implements ProduitRepositoryInterface
{

    public function rechercheProduitById($id)
    {
        return Produit::findOrFail($id);
    }

    public function addProduit(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Produit::create($data);
    }

    public function updateProduit($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Produit = Produit::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Produit->update($merged);

        return $Produit;
    }

    public function deleteProduit($id)
    {
        $Produit= Produit::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Produit) {
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
