<?php

namespace App\Services;



use App\Helpers\SessionHelper;
use App\Models\Classe;
use App\Models\Cycle;
use App\Models\Detail;
use App\Models\Inscription;
use App\Models\Niveau;
use App\Models\Paiement;
use App\Types\StatutPaiement;
use App\Types\TypeInscription;
use App\Types\TypePaiement;
use App\Types\TypeStatus;
use Carbon\Carbon;

class PaiementService
{


    /**
     * Retourne le chiffre d'affaires annuel filtré
     *
     * @param int $annee
     * @param array $filtres (ex : ['type_paiement' => 'scolarite', 'cycle_id' => 1])
     * @return float
     */
    public function getChiffreAffaireAnnuel(int $annee, array $filtres = []): float
    {
        $query = Detail::query()
            ->where('etat', TypeStatus::ACTIF)
            ->where('annee_id',$annee )
            ->where('statut_paiement', StatutPaiement::ENCAISSE)
            ->whereHas('inscription', function ($q) use ($annee, $filtres) {


                if (isset($filtres['cycle_id'])) {
                    $q->where('cycle_id', $filtres['cycle_id']);
                }
                if (isset($filtres['niveau_id'])) {
                    $q->where('niveau_id', $filtres['niveau_id']);
                }
                if (isset($filtres['classe_id'])) {
                    $q->where('classe_id', $filtres['classe_id']);
                }
            });

        // Filtres liés au modèle Detail
        if (isset($filtres['type_paiement'])) {
            $query->where('type_paiement', $filtres['type_paiement']);
        }

        if (isset($filtres['date_debut']) && isset($filtres['date_fin'])) {
            $query->whereBetween('created_at', [$filtres['date_debut'], $filtres['date_fin']]);
        }

        return $query->sum('montant');


    }



    /**
     * Retourne le chiffre d'affaires du mois en cours pour une année donnée, avec filtres
     *
     * @param int $annee
     * @param array $filtres
     * @return float
     */
    public function getChiffreAffaireMoisEnCours(int $annee, array $filtres = []): float
    {
        // Déterminer le mois actuel
        $moisEnCours = Carbon::now()->format('Y-m');

        $query = Detail::query()
            ->selectRaw('SUM(montant) as total')
            ->where('etat', TypeStatus::ACTIF)
            ->where('statut_paiement', 'encaisse')
            ->whereYear('created_at', $annee)
            ->whereMonth('created_at', Carbon::now()->month);

        // Filtres liés au modèle Inscription
        $query->whereHas('inscription', function ($q) use ($annee, $filtres) {
            $q->where('annee_id', $annee);

            if (isset($filtres['cycle_id'])) {
                $q->where('cycle_id', $filtres['cycle_id']);
            }
            if (isset($filtres['niveau_id'])) {
                $q->where('niveau_id', $filtres['niveau_id']);
            }
            if (isset($filtres['classe_id'])) {
                $q->where('classe_id', $filtres['classe_id']);
            }
        });

        // Filtres sur le modèle Detail (type_paiement, dates…)
        if (isset($filtres['type_paiement'])) {
            $query->where('type_paiement', $filtres['type_paiement']);
        }

        if (isset($filtres['date_debut']) && isset($filtres['date_fin'])) {
            $query->whereBetween('created_at', [$filtres['date_debut'], $filtres['date_fin']]);
        }

        $resultat = $query->first();

        return $resultat ? (float)$resultat->total : 0.0;
    }



    /**
     * Retourne le chiffre d'affaires de la semaine en cours pour une année donnée, avec filtres
     *
     * @param int $annee
     * @param array $filtres
     * @return float
     */
    public function getChiffreAffaireSemaineEnCours(int $annee, array $filtres = []): float
    {
        // Déterminer la semaine actuelle de l'année
        $semaineEnCours = Carbon::now()->format('Y-\WW');

        $query = Detail::query()
            ->selectRaw('SUM(montant) as total')
            ->where('etat', TypeStatus::ACTIF)
            ->where('statut_paiement', 'encaisse')
            ->whereYear('created_at', $annee)
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(), // Début de la semaine actuelle
                Carbon::now()->endOfWeek()     // Fin de la semaine actuelle
            ]);

        // Filtres liés au modèle Inscription
        $query->whereHas('inscription', function ($q) use ($annee, $filtres) {
            $q->where('annee_id', $annee);

            if (isset($filtres['cycle_id'])) {
                $q->where('cycle_id', $filtres['cycle_id']);
            }
            if (isset($filtres['niveau_id'])) {
                $q->where('niveau_id', $filtres['niveau_id']);
            }
            if (isset($filtres['eleve_id'])) {
                $q->where('eleve_id', $filtres['eleve_id']);
            }
        });

        // Filtres sur le modèle Detail (type_paiement, dates…)
        if (isset($filtres['type_paiement'])) {
            $query->where('type_paiement', $filtres['type_paiement']);
        }

        if (isset($filtres['date_debut']) && isset($filtres['date_fin'])) {
            $query->whereBetween('created_at', [$filtres['date_debut'], $filtres['date_fin']]);
        }

        $resultat = $query->first();

        return $resultat ? (float)$resultat->total : 0.0;
    }


    /**
     * Retourne le chiffre d'affaires de la journée en cours pour une année donnée, avec filtres
     *
     * @param int $annee
     * @param array $filtres
     * @return float
     */
    public function getChiffreAffaireJourEnCours(int $annee, array $filtres = []): float
    {
        // Déterminer la date actuelle
        $dateJourEnCours = Carbon::now()->format('Y-m-d');

        $query = Detail::query()
            ->selectRaw('SUM(montant) as total')
            ->where('etat', 'actif')
            ->where('statut_paiement', 'encaisse')
            ->whereYear('created_at', $annee)
            ->whereDate('created_at', $dateJourEnCours); // Filtrer pour la journée actuelle

        // Filtres liés au modèle Inscription
        $query->whereHas('inscription', function ($q) use ($annee, $filtres) {
            $q->where('annee_id', $annee);

            if (isset($filtres['cycle_id'])) {
                $q->where('cycle_id', $filtres['cycle_id']);
            }
            if (isset($filtres['niveau_id'])) {
                $q->where('niveau_id', $filtres['niveau_id']);
            }
            if (isset($filtres['eleve_id'])) {
                $q->where('eleve_id', $filtres['eleve_id']);
            }
        });

        // Filtres sur le modèle Detail (type_paiement, dates…)
        if (isset($filtres['type_paiement'])) {
            $query->where('type_paiement', $filtres['type_paiement']);
        }

        if (isset($filtres['date_debut']) && isset($filtres['date_fin'])) {
            $query->whereBetween('created_at', [$filtres['date_debut'], $filtres['date_fin']]);
        }

        $resultat = $query->first();

        return $resultat ? (float)$resultat->total : 0.0;
    }


    /**
     * Retourne le chiffre d'affaires entre deux dates pour une année donnée, avec filtres
     *
     * @param int $annee
     * @param string $dateDebut
     * @param string $dateFin
     * @param array $filtres
     * @return float
     */
    public function getChiffreAffaireEntreDeuxDates(int $annee, string $dateDebut, string $dateFin, array $filtres = []): float
    {
        $query = Detail::query()
            ->selectRaw('SUM(montant) as total')
            ->where('etat', 'actif')
            ->where('statut_paiement', 'encaisse')
            ->whereYear('created_at', $annee)
            ->whereBetween('created_at', [$dateDebut, $dateFin]);

        // Filtres liés au modèle Inscription
        $query->whereHas('inscription', function ($q) use ($annee, $filtres) {
            $q->where('annee_id', $annee);

            if (isset($filtres['cycle_id'])) {
                $q->where('cycle_id', $filtres['cycle_id']);
            }
            if (isset($filtres['niveau_id'])) {
                $q->where('niveau_id', $filtres['niveau_id']);
            }
            if (isset($filtres['eleve_id'])) {
                $q->where('eleve_id', $filtres['eleve_id']);
            }
        });

        // Filtres sur le modèle Detail (type_paiement, etc.)
        if (isset($filtres['type_paiement'])) {
            $query->where('type_paiement', $filtres['type_paiement']);
        }

        $resultat = $query->first();

        return $resultat ? $resultat->total : 0;
    }


    /**
     * Retourne pour chaque élève inscrit le chiffre d'affaires d'une année donnée,
     * ainsi que la liste des cycles, niveaux, classes, avec filtres facultatifs.
     *
     * @param int $annee
     * @param array $filtres
     * @return array
     */
    public function getChiffreAffaireParEleve(int $annee, array $filtres = []): array
    {
        $inscriptions = Inscription::with(['eleve', 'cycle', 'niveau', 'classe'])
            ->where('annee_id', $annee)
            ->when(isset($filtres['cycle_id']), fn($q) => $q->where('cycle_id', $filtres['cycle_id']))
            ->when(isset($filtres['niveau_id']), fn($q) => $q->where('niveau_id', $filtres['niveau_id']))
            ->when(isset($filtres['classe_id']), fn($q) => $q->where('classe_id', $filtres['classe_id']))
            ->get();

        $resultats = [];

        foreach ($inscriptions as $inscription) {
            $total = $inscription->details()
                ->where('etat', TypeStatus::ACTIF)
                ->where('statut_paiement', StatutPaiement::ENCAISSE)
                ->sum('montant');

            $resultats[] = [
                'eleve_id'     => $inscription->eleve->id,

                 'inscription_id'     => $inscription->id,
                 'type_inscription'     => $inscription->type_inscription,
                'nom_prenom'          => $inscription->eleve->nom.' '.$inscription->eleve->prenom,

                'cycle'        => $inscription->cycle->libelle ?? null,
                'niveau'       => $inscription->niveau->libelle ?? null,
                'classe'       => $inscription->classe->libelle ?? null,
                'montant_total_paye' => $total,
            ];
        }

        return [
            'inscriptions'  => $resultats,
            'cycles' => Cycle::where('etat', TypeStatus::ACTIF)->get(),
            'niveaux' => Niveau::where('etat', TypeStatus::ACTIF)->get(),
            'classes' => Classe::where('etat', TypeStatus::ACTIF)->get(),
        ];
    }

/**
     * Retourne pour chaque élève inscrit la situatioon par ecolage , cantine , bus etc
     * ainsi que la liste des cycles, niveaux, classes, avec filtres facultatifs.
     *
     * @param int $annee
     * @param array $filtres
     * @return array
     */

    public function getSituationParEleveParAnnee(int $annee, array $filters = [])
    {
        $query = Inscription::with(['eleve', 'niveau', 'classe', 'cycle', 'details' => function ($q) use ($annee) {
            $q->where('annee_id', $annee)
                ->where('etat', TypeStatus::ACTIF)
                ->where('statut_paiement', StatutPaiement::ENCAISSE);
        }])
            ->where('annee_id', $annee)
            ->when(isset($filters['cycle_id']), fn($q) => $q->where('cycle_id', $filters['cycle_id']))
            ->when(isset($filters['niveau_id']), fn($q) => $q->where('niveau_id', $filters['niveau_id']))
            ->when(isset($filters['classe_id']), fn($q) => $q->where('classe_id', $filters['classe_id']));

        $inscriptions = $query->get();

        $result = [];

        foreach ($inscriptions as $inscription) {
            $eleve = $inscription->eleve;

            $montantScolarite = $inscription->details->where('type_paiement', TypePaiement::FRAIS_SCOLARITE)->sum('montant');
            $montantCantine   = $inscription->details->where('type_paiement', TypePaiement::CANTINE)->sum('montant');
            $montantBus       = $inscription->details->where('type_paiement', TypePaiement::BUS)->sum('montant');
            $total            = $inscription->details->sum('montant');

            $result[] = [

                'nom_prenom'     => $eleve->nom. ' '.$eleve->prenom,
                'niveau'     => $inscription->niveau->libelle ?? '',
                'classe'     => $inscription->classe->libelle ?? '',
                'scolarite'  => $montantScolarite,
                'cantine'    => $montantCantine,
                'bus'        => $montantBus,
                'total'      => $total,
            ];
        }

        return [
            'inscriptions'  => $result,
            'cycles' => Cycle::where('etat', TypeStatus::ACTIF)->get(),
            'niveaux' => Niveau::where('etat', TypeStatus::ACTIF)->get(),
            'classes' => Classe::where('etat', TypeStatus::ACTIF)->get(),
        ];
    }



/**
     * Retourne pour chaque famille  inscrit le nombre d enfant inscrits et le chiffres d affaire
     * ainsi que la liste des cycles, niveaux, classes, avec filtres facultatifs.
     *
     * @param int $annee
     * @param array $filtres
     * @return array
     */

    public function getChiffreAffaireParFamille(int $annee, array $filters = [])
    {
        $query = Inscription::with(['espace', 'details' => function ($q) use ($annee) {
            $q->where('annee_id', $annee)
                ->where('etat', TypeStatus::ACTIF)
                ->where('statut_paiement', StatutPaiement::ENCAISSE);
        }])
            ->when(isset($filters['cycle_id']), fn($q) => $q->where('cycle_id', $filters['cycle_id']))
            ->when(isset($filters['niveau_id']), fn($q) => $q->where('niveau_id', $filters['niveau_id']))
            ->when(isset($filters['classe_id']), fn($q) => $q->where('classe_id', $filters['classe_id']))
            ->whereNotNull('espace_id');

        $inscriptions = $query->get();

        $familles = [];

        foreach ($inscriptions as $inscription) {
            $familleId = $inscription->espace->id ?? null;

            if (!$familleId) {
                continue;
            }

            if (!isset($familles[$familleId])) {
                $familles[$familleId] = [
                    'famille' => $inscription->espace->nom_famille ?? 'Inconnu',
                    'nb_enfants' => 0,
                    'montant_total' => 0,
                ];
            }

            $familles[$familleId]['nb_enfants']++;
            $familles[$familleId]['montant_total'] += $inscription->details->sum('montant');
        }



        return [
            'espaces'  => array_values($familles) ,
            'cycles' => Cycle::where('etat', TypeStatus::ACTIF)->get(),
            'niveaux' => Niveau::where('etat', TypeStatus::ACTIF)->get(),
            'classes' => Classe::where('etat', TypeStatus::ACTIF)->get(),
        ];


            // Réindexation propre
    }



    /**
     * Retourne tous les paiements avec possibilite de filtrer par
     * cycle,  niveaux, classes, avec filtres facultatifs.
     *
     * @param int $anneeScolaireId
     * @param array $filtres
     * @param int $utilisateurId
     * @return array
     */

    public function getPaiementsFiltres($anneeScolaireId, array $filtres = [],  $utilisateurId = null)
    {
        return Paiement::with([
            'utilisateur',
            'details',
            'inscription.eleve',
            'inscription.classe.niveau.cycle'
        ])
            ->where('etat', TypeStatus::ACTIF)
            ->whereHas('inscription', function ($q) use ($anneeScolaireId) {
                $q->where('annee_id', $anneeScolaireId);
            })
            ->when($filtres['cycle_id'] ?? null, fn($q, $id) =>
            $q->whereHas('inscription.classe.niveau.cycle', fn($sq) => $sq->where('id', $id))
            )
            ->when($filtres['niveau_id'] ?? null, fn($q, $id) =>
            $q->whereHas('inscription.classe.niveau', fn($sq) => $sq->where('id', $id))
            )
            ->when($filtres['classe_id'] ?? null, fn($q, $id) =>
            $q->whereHas('inscription.classe', fn($sq) => $sq->where('id', $id))
            )
            ->when($filtres['mode_paiement'] ?? null, fn($q, $mode) =>
            $q->where('mode_paiement', $mode)
            )
            ->when($filtres['statut'] ?? null, fn($q, $statut) =>
            $q->where('statut', $statut)
            )
            ->when($filtres['date_debut'] ?? null, fn($q, $date) =>
            $q->whereDate('date_paiement', '>=', $date)
            )
            ->when($filtres['date_fin'] ?? null, fn($q, $date) =>
            $q->whereDate('date_paiement', '<=', $date)
            )

            ->when($utilisateurId, fn($q, $utilisateurId) =>
            $q->where('utilisateur_id', $utilisateurId)
            )

            ->orderBy('date_paiement', 'desc')
            ->get()


            ->map(function ($paiement) {

                $montantTotal = $paiement->details
                    ->where('etat', TypeStatus::ACTIF) // <--- filtre ici
                    ->sum('montant');

                $statuts = [
                    1 => 'En attente',
                    2 => 'Encaissé',
                ];
                return [
                    'id' => $paiement->id,
                    'reference' => $paiement->reference,
                    'payeur' => $paiement->payeur,
                    'date_paiement' => $paiement->date_paiement->format('d/m/Y'),
                    'eleve' => $paiement->inscription->eleve->nom_complet,
                    'niveau'     => $paiement->inscription->niveau->libelle ?? '',
                    'classe'     => $paiement->inscription->classe->libelle ?? '',
                    'montant_total' => $montantTotal,
                    'mode_paiement' => $paiement->mode_paiement,
                    'comptable' => $paiement->utilisateur->nom_complet,
                    'statut_paiement' => $statuts[$paiement->statut_paiement] ?? 'Inconnu',
                ];
            });
    }



    /**
     * Retourne tous les paiements de paiement de scolarite  avec possibilite de filtrer par
     * cycle,  niveaux, classes, avec filtres facultatifs.
     *
     * @param int $anneeScolaireId
     * @param array $filtres

     * @return array
     */

    public function getElevesAyantPayeScolarité($anneeScolaireId, array $filtres = [])
    {
        $query = Detail::where('type_paiement', TypePaiement::FRAIS_SCOLARITE)
            ->where('etat', 'actif') // 👈 uniquement les détails actifs
            ->whereHas('paiement.inscription', function ($q) use ($anneeScolaireId, $filtres) {
                $q->where('annee_id', $anneeScolaireId)
                    ->when($filtres['classe_id'] ?? null, function ($q, $classeId) {
                        $q->where('classe_id', $classeId);
                    })
                    ->when($filtres['niveau_id'] ?? null, function ($q, $niveauId) {
                        $q->whereHas('classe', function ($q) use ($niveauId) {
                            $q->where('niveau_id', $niveauId);
                        });
                    })
                    ->when($filtres['cycle_id'] ?? null, function ($q, $cycleId) {
                        $q->whereHas('classe.niveau', function ($q) use ($cycleId) {
                            $q->where('cycle_id', $cycleId);
                        });
                    });
            })
            ->with(['paiement.inscription.eleve', 'paiement.inscription.classe.niveau'])
            ->get();

        return $query->groupBy(fn($detail) => $detail->paiement->inscription->eleve->id)
            ->map(function ($details) {
                $inscription = $details->first()->paiement->inscription;
                $eleve = $inscription->eleve;
                $classe = $inscription->classe;
                $niveau = $inscription->niveau;
                $cycle = $inscription->cycle;
                $totalPaye = $details->sum('montant');
                $frais = $inscription->frais_scolarite;

                return [

                    'nom_prenom' => $eleve->nom_complet,
                    'niveau' => $niveau->libelle ?? '',
                    'classe' => $classe->libelle ?? '',
                    'total_paye' => $totalPaye,
                    'frais_scolarite' => $frais,
                    'statut' => $totalPaye >= $frais ? 'soldé' : 'non soldé',
                ];
            })->values();
    }




    /**
     * Retourne tous les paiements de paiement cantine   avec possibilite de filtrer par
     * cycle,  niveaux, classes, avec filtres facultatifs.
     *
     * @param int $anneeScolaireId
     * @param array $filtres

     * @return array
     */

    public function getElevesAyantPayeCantine($anneeScolaireId, array $filtres = [])
    {
        $query = Detail::where('type_paiement', TypePaiement::CANTINE)
            ->where('etat', 'actif') // 👈 uniquement les détails actifs
            ->whereHas('paiement.inscription', function ($q) use ($anneeScolaireId, $filtres) {
                $q->where('annee_id', $anneeScolaireId)
                    ->when($filtres['classe_id'] ?? null, function ($q, $classeId) {
                        $q->where('classe_id', $classeId);
                    })
                    ->when($filtres['niveau_id'] ?? null, function ($q, $niveauId) {
                        $q->whereHas('classe', function ($q) use ($niveauId) {
                            $q->where('niveau_id', $niveauId);
                        });
                    })
                    ->when($filtres['cycle_id'] ?? null, function ($q, $cycleId) {
                        $q->whereHas('classe.niveau', function ($q) use ($cycleId) {
                            $q->where('cycle_id', $cycleId);
                        });
                    });
            })
            ->with(['paiement.inscription.eleve', 'paiement.inscription.classe.niveau'])
            ->get();

        return $query->groupBy(fn($detail) => $detail->paiement->inscription->eleve->id)
            ->map(function ($details) {
                $inscription = $details->first()->paiement->inscription;
                $eleve = $inscription->eleve;
                $classe = $inscription->classe;
                $niveau = $inscription->niveau;
                $cycle = $inscription->cycle;
                $totalPaye = $details->sum('montant');
                $frais = $inscription->frais_scolarite;

                return [

                    'nom_prenom' => $eleve->nom_complet,
                    'niveau' => $niveau->libelle ?? '',
                    'classe' => $classe->libelle ?? '',
                    'total_paye' => $totalPaye,
                    'frais_scolarite' => $frais,
                    'statut' => $totalPaye >= $frais ? 'soldé' : 'non soldé',
                ];
            })->values();
    }


}
