<?php

namespace App\Repositories;

use App\Models\Cheque;
use App\Repositories\Interfaces\ChequeRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class ChequeRepository implements ChequeRepositoryInterface
{

    public function rechercheChequeById($id)
    {
        return Cheque::findOrFail($id);
    }

    public function addCheque(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Cheque::create($data);
    }

    public function updateCheque($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Cheque = Cheque::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [


            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Cheque->update($merged);

        return $Cheque;
    }

    public function deleteCheque($id)
    {
        $Cheque= Cheque::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Cheque) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Cheque::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Cheque::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    public function getListeAvecTotalNiveau(array $filters = [] )
    {
        $query = Cheque::withCount('niveaux')
            ->where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->get();
    }
}
