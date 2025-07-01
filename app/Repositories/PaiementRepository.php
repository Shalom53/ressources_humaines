<?php

namespace App\Repositories;

use App\Models\Paiement;
use App\Repositories\Interfaces\PaiementRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class PaiementRepository implements PaiementRepositoryInterface
{

    public function recherchePaiementById($id)
    {
        return Paiement::findOrFail($id);
    }

    public function addPaiement(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Paiement::create($data);
    }

    public function updatePaiement($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Paiement = Paiement::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Paiement->update($merged);

        return $Paiement;
    }

    public function deletePaiement($id)
    {
        $Paiement= Paiement::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Paiement) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Paiement::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Paiement::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
