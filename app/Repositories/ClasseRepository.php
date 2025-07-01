<?php

namespace App\Repositories;

use App\Models\Classe;
use App\Repositories\Interfaces\ClasseRepositoryInterface;
use App\Types\TypeStatus;
use Carbon\Carbon;

class ClasseRepository implements ClasseRepositoryInterface
{

    public function rechercheClasseById($id)
    {
        return Classe::findOrFail($id);
    }

    public function addClasse(array $data)
    {
        // Valeurs par défaut
        $default = [

            'created' => Carbon::now(),
        ];

        // Fusionne les données manquantes avec les valeurs par défaut
        $data = array_merge($default, $data);

        return Classe::create($data);
    }

    public function updateClasse($id, array $data)
    {
        // On récupère l’élément ou on échoue
        $Classe = Classe::findOrFail($id);

        // Valeurs par défaut (peuvent être ignorées si déjà présentes)
        $default = [
            

            'updated' => Carbon::now(), // ou 'updated_at'
        ];

        // Fusionne les valeurs manquantes avec l'existant
        $merged = array_merge($default, $data);

        // Met à jour le modèle
        $Classe->update($merged);

        return $Classe;
    }

    public function deleteClasse($id)
    {
        $Classe= Classe::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Classe) {
            return 1;
        }
        return 0;
    }

    public function getListe(array $filters = [] )
    {
        $query = Classe::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

                $query->where($field, $value);

        }

        return $query->get();
    }

    public function getTotal(array $filters = [] )
    {
        $query = Classe::where('etat', TypeStatus::ACTIF);

        // Appliquer dynamiquement les autres filtres
        foreach ($filters as $field => $value) {

            $query->where($field, $value);

        }

        return $query->count();
    }


    
}
