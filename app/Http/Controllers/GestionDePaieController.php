<?php

namespace App\Http\Controllers;

use App\Models\Remuneration;
use App\Models\Personnels;
use App\Models\Contrat;
use App\Models\Poste;
use Illuminate\Http\Request;
use App\Models\BulletinPaie;
use App\Models\PaiementEmploye;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GestionDePaieController extends Controller
{
    //

     public function fiche(Request $request)
    {
         
        $personnels = Personnels::with([
           'poste',
            'enseignant',
            'administratif',
            'paiements'
        ])
        ->where('etat', 1)
        ->get();
        return view('GestionDePaie.fiche', compact('personnels'));
    }


    

    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'adresse' => 'required',
            'modal_poste' => 'required',
        ]);

        $personnelId = $request->personnel_id;
        $periode = $request->periode;
        $moisPaie = date("F Y", strtotime($periode));

        // ✅ Vérification du paiement déjà existant
        $existe = PaiementEmploye::where('personnel_id', $personnelId)
                    ->where('mois_paie', $moisPaie)
                    ->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => "Le paiement pour le mois de $moisPaie a déjà été effectué pour ce employé."
            ], 409); // Erreur conflit
        }

        $personnel = Personnels::findOrFail($personnelId);


      
        $salaireBase = 0;
        $salaireHoraire = 0;

        if ($personnel->enseignant) {
        // Récupérer les infos de l'enseignant
            $enseignant = $personnel->enseignant; // relation hasOne avec la table personnels_enseignants
            $poste = $personnel->poste; // relation vers la table postes contenant salaire_horaire

            $volumeHoraire = $enseignant->volume_horaire ?? 0;
            $salaireHoraire = $poste->salaire_horaire ?? 0;

            $salaireHoraire = floatval($salaireHoraire);
            $salaireBase = $salaireHoraire * $volumeHoraire;
        } elseif ($personnel->administratif) {
            $salaireBase = floatval($request->input('salaire_base', 0));
        }


        // Convertir tous les champs numériques
        $heuresSupp = floatval($request->input('heures_supp', 0));
        $logement = floatval($request->input('logement', 0));
        $commission = floatval($request->input('commission', 0));
        $transport = floatval($request->input('transport', 0));
        $conges = floatval($request->input('conges', 0));
        $primeRepos = floatval($request->input('prime_repos', 0));
        $divers = floatval($request->input('divers', 0));

        $cnss = floatval($request->input('cnss', 0));
        $ins = floatval($request->input('ins', 0));
        $irpp = floatval($request->input('irpp', 0));
        $tcs = floatval($request->input('tcs', 0));
        $credit = floatval($request->input('credit', 0));
        $absences = floatval($request->input('absences', 0));
        $avanceSalaire = floatval($request->input('avance_salaire', 0));
        $acompte = floatval($request->input('acompte', 0));
        $autreRetenue = floatval($request->input('autre_retenue', 0));

        // Calculs
        $salaireBrut = $salaireBase + $heuresSupp + $logement + $commission + $transport + $conges + $primeRepos + $divers;
        $totalRetenue = $cnss + $ins + $irpp + $tcs + $credit + $absences + $avanceSalaire + $acompte + $autreRetenue;
        $salaireNet = $salaireBrut - $totalRetenue;

        // Création du bulletin
        $bulletin = BulletinPaie::create([
            'reference' => strtoupper(substr($request->nom, 0, 3)) . '-BULL-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT),
            'periode' => $periode,
            'personnel_id' => $personnelId,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'poste' => $personnel->enseignant ? 'Enseignant' : ($personnel->administratif ? 'Administratif' : 'Inconnu'),
            'salaire_base' => $salaireBase,
            'salaire_horaire' => $salaireHoraire,
            'heures_supp' => $heuresSupp,
            'logement' => $logement,
            'commission' => $commission,
            'transport' => $transport,
            'conges' => $conges,
            'prime_repos' => $primeRepos,
            'divers' => $divers,
            'salaire_brut' => $salaireBrut,
            'cnss' => $cnss,
            'ins' => $ins,
            'irpp' => $irpp,
            'tcs' => $tcs,
            'credit' => $credit,
            'absences' => $absences,
            'avance_salaire' => $avanceSalaire,
            'acompte' => $acompte,
            'autre_retenue' => $autreRetenue,
            'total_retenue' => $totalRetenue,
            'salaire_net' => $salaireNet,
            'date_paiement' => now(),
        ]);

        // Paiement
        PaiementEmploye::create([
            'personnel_id' => $personnelId,
            'montant' => $salaireNet,
            'date_paiement' => now(),
            'mode_paiement' => $request->mode_paiement ?? 'Espèces',
            'mois_paie' => date("F Y", strtotime($periode)),
            'note' => $request->note,
        ]);

        return response()->json([
        'success' => true,
        'bulletin_id' => $bulletin->id,
        'pdf_url' => route('imprimer.bulletin', ['id' => $bulletin->id])
        ]);

    }


    public function imprimer($id)
    {
        $bulletin = BulletinPaie::findOrFail($id);
        $personnel = $bulletin->personnels;

        return view('GestionDePaie.pdf', [
            'reference' => $bulletin->reference,
            'bulletin' => $bulletin,
            'personnel' => $personnel,
        ]);
    }













public function Paiement(Request $request)
{
    // 1. Mois sélectionné ou actuel
    $mois = $request->input('mois') ?? Carbon::now()->format('Y-m');
    $debutMois = Carbon::createFromFormat('Y-m', $mois)->startOfMonth();
    $finMois = Carbon::createFromFormat('Y-m', $mois)->endOfMonth();

    // 2. Charger les personnels avec les relations nécessaires
    $personnels = Personnels::with([
        'poste',
        'remuneration.primes',
        'remuneration.retenues',
        'billetage',
        'banque',
        'contrat'
    ])
    ->where('etat', 1)
    ->whereIn('statut', ['actif', 'congé']) // Seuls les statuts valides
    ->get();

    // 3. Filtrer les personnels éligibles
    $personnelsEligibles = $personnels->filter(function ($p) use ($debutMois, $finMois) {
        $contrat = $p->contrat;

        if (!$contrat || $contrat->etat != 1 || strtolower($contrat->statut) !== 'actif') {
            return false;
        }

        $typeContrat = strtolower($contrat->type);

        // Déterminer la date de début réelle à prendre en compte
        $contratDebut = $contrat->date_debut 
            ? Carbon::parse($contrat->date_debut)
            : ($contrat->updated_at ?? $contrat->created_at);

        // Si la date de début est après la fin du mois sélectionné → non éligible
        if ($contratDebut->gt($finMois)) return false;

        // Si contrat NON CDI → on vérifie aussi la date de fin
        if ($typeContrat !== 'cdi') {
            $contratFin = $contrat->date_fin 
                ? Carbon::parse($contrat->date_fin)
                : null;

            if ($contratFin && $contratFin->lt($debutMois)) return false;
        }

        // Vérifier qu’il y a un mode de paiement valide
        $hasBilletage = $p->billetage && $p->billetage->etat == 1;
        $hasBanque = $p->banque && $p->banque->etat == 1;

        return $hasBilletage || $hasBanque;
    });



    // 4. Calcul du salaire net
    $calculSalaireNet = function ($remuneration) use ($debutMois) {
        if (!$remuneration) return 0;

        $salaireBrut = $remuneration->salaire_brut ?? 0;

        $totalPrimes = $remuneration->primes->filter(function ($prime) use ($debutMois) {
            if ($prime->etat != 1) return false;
            if (strtolower($prime->periode) === 'indéterminé') return true;

            $mois = (int) $prime->periode;
            $ref = $prime->updated_at ?? $prime->created_at;

            return $ref->copy()->addMonths($mois)->greaterThanOrEqualTo($debutMois);
        })->sum('montant');

        $totalRetenues = $remuneration->retenues->filter(function ($retenue) use ($debutMois) {
            if ($retenue->etat != 1) return false;
            if (strtolower($retenue->periode) === 'indéterminé') return true;

            $mois = (int) $retenue->periode;
            $ref = $retenue->updated_at ?? $retenue->created_at;

            return $ref->copy()->addMonths($mois)->greaterThanOrEqualTo($debutMois);
        })->sum('montant');

        return $salaireBrut + $totalPrimes - $totalRetenues;
    };

    // 5. Billetage
    $billetagePersonnels = $personnelsEligibles->filter(fn($p) => $p->billetage && $p->billetage->etat == 1);
    $nbBilletage = $billetagePersonnels->count();
    $totalBilletageSalaire = $billetagePersonnels->sum(fn($p) => $calculSalaireNet($p->remuneration));

    // 6. Banque
    $banquePersonnels = $personnelsEligibles->filter(fn($p) => $p->banque && $p->banque->etat == 1);
    $nbBanque = $banquePersonnels->count();
    $totalBanqueSalaire = $banquePersonnels->sum(fn($p) => $calculSalaireNet($p->remuneration));

    // 7. Vue
    return view('GestionDePaie.Paiement', compact(
        'personnelsEligibles',
        'nbBilletage',
        'totalBilletageSalaire',
        'nbBanque',
        'totalBanqueSalaire',
        'mois'
    ));
}






}
 