<?php

namespace App\Http\Controllers;
use App\Models\Personnels;
use App\Models\Poste;
use App\Models\Contrat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ContratController extends Controller
{
    //


    public function index()
    {
        // Récupère uniquement les personnels actifs avec leurs postes
        $personnels = Personnels::with('poste')
            ->where('etat', 1)
            ->get();

        // Récupère tous les contrats avec le personnel associé
        $contrats = Contrat::with('personnel')->get();

        // Retourne la vue avec les deux variables
        return view('informations.contrats', compact('personnels', 'contrats'));
    }






    public function store(Request $request)
    {
        $request->validate([
            'personnel_id' => 'required|exists:personnels,id',
            'type' => 'required|string|in:CDD,CDI,Stage,Prestation',
            'date_debut' => 'required|date',
            'fichier' => 'required|file|mimes:pdf|max:10240',
        ]);

        $fichierNom = time() . '_' . $request->file('fichier')->getClientOriginalName();
        $request->file('fichier')->move(public_path('contrats'), $fichierNom);

        Contrat::create([
            'personnel_id' => $request->personnel_id,
            'type' => $request->type,
            'Dure' => $request->Dure,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'salaire' => $request->salaire,
            'description' => $request->description,
            'fichier' => 'contrats/' . $fichierNom,
            'statut' => 'actif',
            'etat' => true,
        ]);

        return response()->json(['message' => 'Contrat ajouté avec succès']);
    }

        public function edit($id)
    {
        $contrat = Contrat::find($id);

        if (!$contrat) {
            return response()->json(['message' => 'Contrat non trouvé'], 404);
        }

        return response()->json($contrat);
    }


    public function update(Request $request, Contrat $contrat)
    {
        $request->validate([
            'type' => 'required|string|in:CDD,CDI,Stage,Prestation',
            'date_debut' => 'required|date',
            'fichier' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->only(['type', 'Dure', 'date_debut', 'date_fin', 'salaire', 'description']);

        if ($request->hasFile('fichier')) {
            $fichierNom = time() . '_' . $request->file('fichier')->getClientOriginalName();
            $request->file('fichier')->move(public_path('contrats'), $fichierNom);
            $data['fichier'] = 'contrats/' . $fichierNom;
        }

        $contrat->update($data);

        return response()->json(['message' => 'Contrat modifié avec succès']);
    }



public function renouvelerIdentique($id)
{
    $ancienContrat = Contrat::findOrFail($id);

    $ancienContrat->statut = 'expiré';
    $ancienContrat->save();


    $nouveauContrat = $ancienContrat->replicate();


    $nouveauContrat->date_debut = now()->toDateString();
    $nouveauContrat->date_fin = $this->calculerDateFin($nouveauContrat->date_debut, $ancienContrat->Dure);


    $nouveauContrat->statut = 'actif';

  
    $nouveauContrat->created_at = now();
    $nouveauContrat->updated_at = now();

    
    $nouveauContrat->save();

    return response()->json(['message' => 'Contrat reconduit avec succès.']);
}






        public function calculerDateFin(string $dateDebut, string $duree): ?string
        {
            $debut = Carbon::parse($dateDebut);
            $duree = strtolower(trim($duree));

            if (empty($duree)) {
                return null;
            }

            // Regexp pour extraire quantité et unité
            if (!preg_match('/(\d+)\s*(jour|jours|semaine|semaines|mois|an|ans)/i', $duree, $matches)) {
                return null;
            }

            $quantite = (int)$matches[1];
            $unite = strtolower($matches[2]);

            switch ($unite) {
                case 'jour':
                case 'jours':
                    $fin = $debut->copy()->addDays($quantite);
                    break;
                case 'semaine':
                case 'semaines':
                    $fin = $debut->copy()->addWeeks($quantite);
                    break;
                case 'mois':
                    $fin = $debut->copy()->addMonths($quantite);
                    break;
                case 'an':
                case 'ans':
                    $fin = $debut->copy()->addYears($quantite);
                    break;
                default:
                    return null;
            }

            return $fin->toDateString();
        }




        public function renouvelerPersonnalise(Request $request)
        {
            $request->validate([
                'personnel_id' => 'required|exists:personnels,id',
                'type' => 'required|string|in:CDD,CDI,Stage,Prestation',
                'date_debut' => 'required|date',
                'Dure' => 'nullable|string|max:255',
                'date_fin' => 'nullable|date',
                'salaire' => 'nullable|numeric',
                'description' => 'nullable|string',
                'fichier' => 'nullable|file|mimes:pdf|max:10240',
            ]);

            // Pas de calcul automatique car Dure est du texte libre
            $dateFin = $request->date_fin;

            // Gestion fichier (optionnel)
            $fichierNom = null;
            if ($request->hasFile('fichier')) {
                $fichierNom = time() . '_' . $request->file('fichier')->getClientOriginalName();
                $request->file('fichier')->move(public_path('contrats'), $fichierNom);
            }

            Contrat::create([
                'personnel_id' => $request->personnel_id,
                'type' => $request->type,
                'Dure' => $request->Dure,
                'date_debut' => $request->date_debut,
                'date_fin' => $dateFin,
                'salaire' => $request->salaire,
                'description' => $request->description,
                'fichier' => $fichierNom ? 'contrats/' . $fichierNom : null,
                'statut' => 'actif',
                'etat' => true,
            ]);

            return response()->json(['message' => 'Contrat renouvelé avec succès']);
        }







        public function showByPersonnel($personnelId)
        {
            $contrat = Contrat::where('personnel_id', $personnelId)->latest()->first();

            if (!$contrat) {
                return response()->json(['message' => 'Aucun contrat trouvé pour ce personnel.'], 404);
            }

            $dateDebut = Carbon::parse($contrat->date_debut)->format('d/m/Y');
            $dateFin = $contrat->date_fin ? Carbon::parse($contrat->date_fin)->format('d/m/Y') : 'Non défini';

            return response()->json([
                'type' => $contrat->type,
                'duree' => $contrat->Dure,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'salaire' => number_format($contrat->salaire, 2, ',', ' '),
                'description' => $contrat->description ?? 'Aucune description',
                'statut' => ucfirst($contrat->statut),
                
                'fichier_url' => asset('storage/contrats/' . $contrat->fichier),
            ]);
        }


        public function changerStatut(Request $request, $id)
        {
            $contrat = Contrat::findOrFail($id);
            $contrat->statut = $request->input('statut');
            $contrat->save();

            return response()->json(['message' => 'Statut mis à jour avec succès']);
        }





}
