<?php

namespace App\Services;

use App\Models\Classe;
use App\Models\Cycle;
use App\Models\Inscription;
use App\Models\Niveau;
use App\Types\Sexe;
use App\Types\TypeInscription;
use App\Types\TypeStatus;

class InscriptionService
{
    public function updateInscriptionEtEleve(int $inscriptionId, array $data): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $inscription = Inscription::with('eleve')->findOrFail($inscriptionId);

        $inscription->update([
            'cycle_id' => $data['cycle_id'],
            'niveau_id' => $data['niveau_id'],
            'classe_id' => $data['classe_id'],
        ]);

        $inscription->eleve->update([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'sexe' => $data['sexe'],
            'date_naissance' => $data['date_naissance'],
            'nationalite_id' => $data['nationalite_id'],
            'lieu_naissance' => $data['lieu_naissance'],
        ]);

        return $inscription;
    }


//Recuperation des données statistiques total eleve , total garcons etc
    public function getDonneesStatistiques(int $anneeId): array
    {
        $baseQuery = Inscription::with('eleve')
            ->where('etat', TypeStatus::ACTIF)
            ->where('annee_id', $anneeId);

        return [
            'total' => (clone $baseQuery)->count(),
            'inscriptions' => (clone $baseQuery)->get(),

            'garcons' => (clone $baseQuery)
                ->whereHas('eleve', fn($q) => $q->where('sexe', Sexe::MASCULIN))->count(),

            'filles' => (clone $baseQuery)
                ->whereHas('eleve', fn($q) => $q->where('sexe', Sexe::FEMININ))->count(),

            'nouveaux' => (clone $baseQuery)
                ->where('type_inscription', TypeInscription::INSCRIPTION)->count(),

            'anciens' => (clone $baseQuery)
                ->where('type_inscription', TypeInscription::REINSCRIPTION)->count(),

            'cycles' => Cycle::where('etat', TypeStatus::ACTIF)->get(),
            'niveaux' => Niveau::where('etat', TypeStatus::ACTIF)->get(),
            'classes' => Classe::where('etat', TypeStatus::ACTIF)->get(),
        ];
    }

//Recuperation des données statistiques total eleve , total garcons etc en fonction des filtres
    public function getStatistiquesAvecFiltres(int $anneeId, array $filtres = []): array
    {
        $query = Inscription::with('eleve') // Inclure l'élève pour accéder à son sexe
        ->where('etat', TypeStatus::ACTIF)
            ->where('annee_id', $anneeId);


        // Appliquer dynamiquement les filtres si présents
        if (!empty($filtres['cycle_id'])) {
            $query->where('cycle_id', $filtres['cycle_id']);
        }

        if (!empty($filtres['niveau_id'])) {
            $query->where('niveau_id', $filtres['niveau_id']);
        }

        if (!empty($filtres['classe_id'])) {
            $query->where('classe_id', $filtres['classe_id']);
        }

        if (!empty($filtres['type_inscription'])) {
            $query->where('type_inscription', $filtres['type_inscription']);
        }

        if (!empty($filtres['sexe'])) {
            $query->whereHas('eleve', function ($q) use ($filtres) {
                $q->where('sexe', $filtres['sexe']);
            });
        }



        $inscriptions = $query->get();

        // Calculs
        $total = $inscriptions->count();
        $garcons = $inscriptions->where('eleve.sexe', Sexe::MASCULIN)->count();
        $filles = $inscriptions->where('eleve.sexe', Sexe::FEMININ)->count();
        $nouveaux = $inscriptions->where('type_inscription', TypeInscription::INSCRIPTION)->count();

        return [
            'total' => $total,
            'garcons' => $garcons,
            'filles' => $filles,
            'nouveaux' => $nouveaux,
            'inscriptions' => $inscriptions
        ];
    }

}
