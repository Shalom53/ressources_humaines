<?php

namespace App\Repositories;

use App\Models\Banque;
use App\Repositories\Interfaces\BanqueRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class BanqueRepository implements BanqueRepositoryInterface
{

    public function rechercheBanqueById($id)
    {
        return Banque::findOrFail($id);
    }

    public function addBanque(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Banque::create($data);
    }

    public function updateBanque($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Banque = Banque::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Banque->update($merged);

        return $Banque;
    }

    public function deleteBanque($id)
    {
        $Banque= Banque::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Banque) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Banque::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Banque::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
