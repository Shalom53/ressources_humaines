<?php

namespace App\Http\Controllers;
use App\Models\Personnels;
use App\Models\PersonnelsEnseignant;
use App\Models\PersonnelsAdministratif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    //
    
    public function Admindashboardpage(Request $request)
        {
            // Personnel global
            $totalActif = Personnels::where('etat', 1)->count();

            // Personnel Enseignant actif (jointure + double etat = 1)
            $totalActifEnseignant = DB::table('personnels_enseignants')
                ->join('personnels', 'personnels_enseignants.personnel_id', '=', 'personnels.id')
                ->where('personnels_enseignants.etat', 1)
                ->where('personnels.etat', 1)
                ->count();

            // Personnel Administratif actif (jointure + double etat = 1)
            $totalActifAdministratif = DB::table('personnels_administratifs')
                ->join('personnels', 'personnels_administratifs.personnel_id', '=', 'personnels.id')
                ->where('personnels_administratifs.etat', 1)
                ->where('personnels.etat', 1)
                ->count();

  

            return view('tableau.page', compact('totalActif', 'totalActifEnseignant', 'totalActifAdministratif'));
        }
}
