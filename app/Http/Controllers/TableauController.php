<?php


namespace App\Http\Controllers;

use App\Repositories\Interfaces\CycleRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use App\Models\Personnels;

use App\Models\Pointage;
use App\Models\PersonnelsEnseignant;
use App\Models\PersonnelsAdministratif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class TableauController extends Controller
{
    protected CycleRepositoryInterface $cycleRepo;

    public function __construct(CycleRepositoryInterface $cycleRepo)
    {
        $this->cycleRepo = $cycleRepo;
    }



// ✅ Afficher la page  des Tableaus





public function tableau(Request $request)
{
    $today = Carbon::today();

    // 1. EFFECTIFS TOTAUX (etat=1 et statut actif ou congé)
    $totalActif = Personnels::where('etat', 1)
        ->whereIn('statut', ['actif', 'congé'])
        ->count();

    // 2. Personnel Enseignant actif (jointure + etat=1 + statut actif ou congé)
    $totalActifEnseignant = DB::table('personnels_enseignants')
        ->join('personnels', 'personnels_enseignants.personnel_id', '=', 'personnels.id')
        ->where('personnels_enseignants.etat', 1)
        ->where('personnels.etat', 1)
        ->whereIn('personnels.statut', ['actif', 'congé'])
        ->count();

    // 3. Personnel Administratif actif (jointure + etat=1 + statut actif ou congé)
    $totalActifAdministratif = DB::table('personnels_administratifs')
        ->join('personnels', 'personnels_administratifs.personnel_id', '=', 'personnels.id')
        ->where('personnels_administratifs.etat', 1)
        ->where('personnels.etat', 1)
        ->whereIn('personnels.statut', ['actif', 'congé'])
        ->count();

    // 4. PERSONNEL ACTIF POUR POINTAGE (etat=1 et statut actif)
    $personnelActifIds = Personnels::where('etat', 1)
        ->where('statut', 'actif')
        ->pluck('id');

    // Pointages du jour (pour ce personnel actif uniquement)
    $pointagesDuJour = Pointage::whereDate('date', $today)
        ->whereIn('personnel_id', $personnelActifIds)
        ->get();

    // Présents : count pointages du jour
    $presentCount = $pointagesDuJour->count();

    // Retards : heure_arrivee > 08:10:00
    $retardCount = $pointagesDuJour->filter(function ($p) {
        return $p->heure_arrivee && $p->heure_arrivee > '08:10:00';
    })->count();

    // Absents = total personnel actif - présents
    $absentCount = $personnelActifIds->count() - $presentCount;

    return view('tableau.page', compact(
        'totalActif',
        'totalActifEnseignant',
        'totalActifAdministratif',
        'presentCount',
        'absentCount',
        'retardCount'
    ));
}




public function statsEvolutionPersonnel()
{
    $moisLabels = [];
    $totalData = [];
    $enseignantsData = [];
    $administratifsData = [];

    // On prend les 6 derniers mois
    for ($i = 5; $i >= 0; $i--) {
        $date = Carbon::now()->subMonths($i);
        $moisLabels[] = $date->translatedFormat('M Y'); // Exemple : "Juin 2025"

        $start = $date->copy()->startOfMonth()->toDateString();
        $end = $date->copy()->endOfMonth()->toDateString();

        // Total personnel actif (etat=1, statut actif ou congé)
        $totalCount = DB::table('personnels')
            ->where('etat', 1)
            ->whereIn('statut', ['Actif', 'Congé'])
            ->whereBetween('created_at', [$start, $end])
            ->count();

        // Personnel Enseignant actif
        $enseignantsCount = DB::table('personnels_enseignants')
            ->join('personnels', 'personnels_enseignants.personnel_id', '=', 'personnels.id')
            ->where('personnels_enseignants.etat', 1)
            ->where('personnels.etat', 1)
            ->whereBetween('personnels.created_at', [$start, $end])
            ->count();

        // Personnel Administratif actif
        $administratifsCount = DB::table('personnels_administratifs')
            ->join('personnels', 'personnels_administratifs.personnel_id', '=', 'personnels.id')
            ->where('personnels_administratifs.etat', 1)
            ->where('personnels.etat', 1)
            ->whereBetween('personnels.created_at', [$start, $end])
            ->count();

        $totalData[] = $totalCount;
        $enseignantsData[] = $enseignantsCount;
        $administratifsData[] = $administratifsCount;
    }

    return response()->json([
        'mois' => $moisLabels,
        'total' => $totalData,
        'enseignants' => $enseignantsData,
        'administratifs' => $administratifsData,
    ]);
}


public function statistiquesPresence30Jours()
{
    $dates = [];
    $presences = [];
    $retards = [];
    $absences = [];

    $personnelActif = Personnels::where('etat', 1)->where('statut', 'actif')->pluck('id');
    $jour = Carbon::today();

    while (count($dates) < 30) {
        // On ne prend que les jours ouvrables (lundi à vendredi)
        if ($jour->isWeekday()) {
            $dateStr = $jour->format('Y-m-d');

            // Récupérer les pointages pour ce jour
            $pointages = Pointage::whereDate('date', $jour)
                ->whereIn('personnel_id', $personnelActif)
                ->get();

            $present = $pointages->count();

            $retard = $pointages->filter(function ($p) {
                return $p->heure_arrivee && $p->heure_arrivee > '08:10:00';
            })->count();

            $absent = $personnelActif->count() - $present;

            $dates[] = $jour->format('d M'); // exemple : "21 Juin"
            $presences[] = $present;
            $retards[] = $retard;
            $absences[] = $absent;
        }

        $jour->subDay(); // jour précédent
    }

    // Inverser les tableaux pour avoir du plus ancien au plus récent
    return response()->json([
        'jours' => array_reverse($dates),
        'presences' => array_reverse($presences),
        'retards' => array_reverse($retards),
        'absences' => array_reverse($absences),
    ]);
}




}
