<?php

namespace App\Repositories;

use App\Models\Inscription;
use App\Repositories\Interfaces\InscriptionRepositoryInterface;
use App\Types\StatutPaiement;
use App\Types\TypeStatus;
use Carbon\Carbon;

class InscriptionRepository implements InscriptionRepositoryInterface
{

    public function rechercheInscriptionById($id)
    {
        return Inscription::findOrFail($id);
    }

    public function addInscription(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Inscription::create($data);
    }

    public function updateInscription($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Inscription = Inscription::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [


            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Inscription->update($merged);

        return $Inscription;
    }

    public function deleteInscription($id)
    {
        $Inscription= Inscription::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Inscription) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Inscription::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Inscription::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    public function getListeAvecTotalPaiement(array $filters = [] )
    {
        $query = Inscription::withSum([
            'details as montant_total_encaisse' => function ($querydetail) {
                $querydetail->where('statut_paiement', StatutPaiement::ENCAISSE)
                    ->where('etat', TypeStatus::ACTIF);
            }
        ], 'montant')

            ->where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->get();
    }


}
