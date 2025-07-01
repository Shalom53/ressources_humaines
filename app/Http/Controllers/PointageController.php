<?php

namespace App\Http\Controllers;
use App\Models\Personnels;
use App\Models\Pointage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Carbon\CarbonPeriod; 
use Illuminate\Support\Facades\DB;

class PointageController extends Controller
{
    //
        public function index()
        {
            return view('Pointage.index'); 
        }


        public function enregistrerPointage(Request $request)
        {
            $request->validate([
                'matricule' => 'required',
                'mot_de_passe' => 'required',
                'type_pointage' => 'required|in:arrivee,depart',
            ]);

            $personnel = Personnels::where('matricule', $request->matricule)->first();

            if (!$personnel || !Hash::check($request->mot_de_passe, $personnel->mot_de_passe)) {
                return back()->with('error', 'Matricule ou mot de passe incorrect');
            }

            $date = Carbon::now()->toDateString();

            // Vérifie si un pointage existe déjà pour aujourd'hui
            $pointage = Pointage::where('personnel_id', $personnel->id)
                ->where('date', $date)
                ->first();

            if ($request->type_pointage === 'depart' && (!$pointage || !$pointage->heure_arrivee)) {
                return back()->with('error', 'Impossible d\'enregistrer le départ sans arrivée préalable.');
            }

            if ($pointage) {
                if (
                    ($request->type_pointage === 'arrivee' && $pointage->heure_arrivee) ||
                    ($request->type_pointage === 'depart' && $pointage->heure_depart)
                ) {
                    return back()->with('error', 'Le pointage pour ce type a déjà été effectué aujourd\'hui.');
                }
            } else {
                $pointage = new Pointage();
                $pointage->personnel_id = $personnel->id;
                $pointage->date = $date;
            }

            $dateObj = Carbon::now();
            $heure = $dateObj->format('H:i');
            $jour = mb_convert_case($dateObj->locale('fr')->isoFormat('dddd'), MB_CASE_TITLE, "UTF-8");
            $jourMois = mb_convert_case($dateObj->locale('fr')->isoFormat('D MMMM'), MB_CASE_TITLE, "UTF-8");

            if ($request->type_pointage === 'arrivee') {
                $pointage->heure_arrivee = $heure;
                $type = "Heure d'arrivée";
            } else {
                $pointage->heure_depart = $heure;
                $type = "Heure de départ";
            }

            $pointage->save();

            $message = "{$personnel->nom} {$personnel->prenom} - {$jour} {$jourMois} - {$type} : {$heure} enregistré avec succès.";

            return back()->with('success', $message);
        }




    public function listePresence(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $personnels = Personnels::where('etat', 1)
            ->where('statut', 'actif')
            ->with(['pointages' => function ($query) use ($date) {
                $query->whereDate('date', $date);
            }])->get();

        return view('Pointage.liste', compact('personnels', 'date'));
    }






    public function statistiques($id)
    {
        $personnel = Personnels::where('etat', 1)
            ->where('statut', 'actif')
            ->with('pointages')
            ->find($id);

        if (!$personnel) {
            return response()->json(['error' => 'Employé non trouvé ou inactif.'], 404);
        }

        $periode = CarbonPeriod::create(
            now()->subDays(30)->startOfDay(),
            now()->startOfDay()
        );

        $presences = 0;
        $absences = 0;
        $retards = 0;

        foreach ($periode as $date) {
            if ($date->isWeekday()) {
                $pointage = $personnel->pointages->firstWhere('date', $date->toDateString());

                if (!$pointage || !$pointage->heure_arrivee) {
                    $absences++;
                } elseif ($pointage->heure_arrivee > '08:00:00') {
                    $retards++;
                } else {
                    $presences++;
                }
            }
        }

        return response()->json([
            'nom' => $personnel->nom,
            'prenom' => $personnel->prenom,
            'presences' => $presences,
            'absences' => $absences,
            'retards' => $retards,
        ]);
    }






    public function statistiquesGlobales()
    {
        $periode = CarbonPeriod::create(
            now()->subDays(30)->startOfDay(),
            now()->startOfDay()
        );

        $jours = [];
        $presences = [];
        $retards = [];
        $absences = [];

        // Récupère tous les personnels avec leurs pointages chargés en eager loading
            $personnels = Personnels::where('etat', 1)
                ->where('statut', 'actif')
                ->with('pointages')
                ->get();

        foreach ($periode as $date) {
            if ($date->isWeekday()) {
                $label = $date->locale('fr')->isoFormat('dd D MMM');
                $jours[] = $label;

                $dateStr = $date->toDateString();

                $presenceCount = 0;
                $retardCount = 0;
                $absenceCount = 0;

                foreach ($personnels as $personnel) {
                    $pointage = $personnel->pointages->firstWhere('date', $dateStr);

                    if (!$pointage || !$pointage->heure_arrivee) {
                        $absenceCount++;
                    } else {
                        if ($pointage->heure_arrivee > '08:00:00') {
                            $retardCount++;
                        } else {
                            $presenceCount++;
                        }
                    }
                }

                $presences[] = $presenceCount;
                $retards[] = $retardCount;
                $absences[] = $absenceCount;
            }
        }

        return response()->json([
            'jours' => $jours,
            'presences' => $presences,
            'retards' => $retards,
            'absences' => $absences,
        ]);
    }

    public function RapportGraphique(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $personnels = Personnels::with(['pointages' => function ($query) use ($date) {
            $query->whereDate('date', $date);
        }])
        ->where('etat', 1)
        ->where('statut', 'actif')
        ->get();

        return view('Pointage.Statistique', compact('personnels', 'date'));
    }






    public function classementAbsences()
    {
        $personnels = Personnels::with('pointages')
            ->where('etat', 1)
            ->where('statut', 'actif')
            ->get();

        $periode = CarbonPeriod::create(
            now()->subDays(30)->startOfDay(),
            now()->startOfDay()
        );

        $classement = $personnels->map(function ($personnel) use ($periode) {
            $presences = 0;
            $retards = 0;
            $absences = 0;

            foreach ($periode as $date) {
                if ($date->isWeekday()) {
                    $pointage = $personnel->pointages->firstWhere('date', $date->toDateString());

                    if (!$pointage || !$pointage->heure_arrivee) {
                        $absences++;
                    } elseif ($pointage->heure_arrivee > '08:00:00') {
                        $retards++;
                    } else {
                        $presences++;
                    }
                }
            }

            return [
                'nom' => $personnel->nom,
                'prenom' => $personnel->prenom,
                'presences' => $presences,
                'retards' => $retards,
                'absences' => $absences,
            ];
        });

        // Trier et retourner les 5 plus absents
        $classement = $classement->sortByDesc('absences')->take(5)->values();

        return response()->json($classement);
    }

    public function tauxGlobaux()
    {
        $periode = CarbonPeriod::create(
            now()->subDays(30)->startOfDay(),
            now()->startOfDay()
        );

        $personnels = Personnels::where('etat', 1)->where('statut', 'actif')->with('pointages')->get();

        $totalJours = 0;
        $totalPrésences = 0;
        $totalRetards = 0;
        $totalAbsences = 0;

        foreach ($periode as $date) {
            if ($date->isWeekday()) {
                $totalJours++;
                foreach ($personnels as $personnel) {
                    $pointage = $personnel->pointages->firstWhere('date', $date->toDateString());

                    if (!$pointage || !$pointage->heure_arrivee) {
                        $totalAbsences++;
                    } elseif ($pointage->heure_arrivee > '08:00:00') {
                        $totalRetards++;
                    } else {
                        $totalPrésences++;
                    }
                }
            }
        }

        $totalEnregistrements = $totalJours * $personnels->count();

        return response()->json([
            'presence' => round(($totalPrésences / $totalEnregistrements) * 100, 2),
            'retard' => round(($totalRetards / $totalEnregistrements) * 100, 2),
            'absence' => round(($totalAbsences / $totalEnregistrements) * 100, 2),
        ]);
    }

    public function topPonctuels()
    {
        $periode = CarbonPeriod::create(
            now()->subDays(30)->startOfDay(),
            now()->startOfDay()
        );

        $personnels = Personnels::where('etat', 1)
            ->where('statut', 'actif')
            ->with('pointages')
            ->get();

        $classement = $personnels->map(function ($personnel) use ($periode) {
            $presencesPonctuelles = 0;

            foreach ($periode as $date) {
                if ($date->isWeekday()) {
                    $pointage = $personnel->pointages->firstWhere('date', $date->toDateString());

                    if ($pointage && $pointage->heure_arrivee <= '08:00:00') {
                        $presencesPonctuelles++;
                    }
                }
            }

            return [
                'nom' => $personnel->nom,
                'prenom' => $personnel->prenom,
                'ponctualite' => $presencesPonctuelles,
            ];
        });

        $top5 = $classement->sortByDesc('ponctualite')->take(5)->values();

        return response()->json($top5);
    }





    public function statistiquesHebdomadaires()
    {
        $periode = CarbonPeriod::create(
            now()->subDays(30)->startOfDay(),
            now()->startOfDay()
        );

        $joursHebdo = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $absences = array_fill_keys($joursHebdo, 0);
        $retards = array_fill_keys($joursHebdo, 0);

        $personnels = Personnels::where('etat', 1)->where('statut', 'actif')->with('pointages')->get();

        foreach ($periode as $date) {
            if ($date->isWeekday()) {
                $jourNom = ucfirst($date->locale('fr')->isoFormat('dddd')); // Ex: "Lundi"
                foreach ($personnels as $personnel) {
                    $pointage = $personnel->pointages->firstWhere('date', $date->toDateString());

                    if (!$pointage || !$pointage->heure_arrivee) {
                        $absences[$jourNom]++;
                    } elseif ($pointage->heure_arrivee > '08:00:00') {
                        $retards[$jourNom]++;
                    }
                }
            }
        }

        return response()->json([
            'jours' => array_values($joursHebdo),
            'absences' => array_values($absences),
            'retards' => array_values($retards),
        ]);
    }






}
