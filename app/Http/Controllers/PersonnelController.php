<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnels;
use App\Models\PersonnelsEnseignant;
use App\Models\PersonnelsAdministratif;
use App\Models\PersonnesAPrevenir;
use App\Models\Prime;
use App\Models\Retenue;
use App\Models\Remuneration;
use App\Models\Banque;
use App\Models\Poste;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\Contrat;
use App\Models\Document;
use Illuminate\Support\Facades\Hash;
use App\Models\Pointage;
use Carbon\CarbonPeriod;


class PersonnelController extends Controller
{
    //
    public function ListeDuPersonnel(Request $request)
    {
        $personnels = Personnels::with(['enseignant', 'administratif', 'personneAPrevenir'])
            ->where('etat', 1)
            ->get();

        return view('personnel.liste', compact('personnels'));
    }
    
    public function ListeAdministratif(Request $request)
    {
        
        $personnels = Personnels::all(); 
        
        
        return view('personnel.administratifs', compact('personnels'));
    }

    public function ListeEnseignant(Request $request)
    {
        
        $personnels = Personnels::all(); 
        
        
        return view('personnel.enseignants', compact('personnels'));
    }

    public function AjoutDuPersonnel(Request $request)
    {
        $postes = Poste::where('etat', 1)->get();
        return view('personnel.ajouter', compact('postes'));
    }


  
    public function enregistrerPersonnel(Request $request)
    {
        
        $request->validate([
          
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'required|email|unique:personnels,email',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'prefecture_naissance' => 'nullable|string|max:255',
            'sexe' => 'required|in:Masculin,Féminin',
            'photo' => 'nullable|image|max:2048',
            'quartier_residentiel' => 'nullable|string|max:255',
            'situation_familiale' => 'required|in:Marié(e),Célibataire,Divorcé(e),Veuf(ve)',
            'nombre_enfants' => 'nullable|integer|min:0',
            'situation_agent' => 'required|in:Permanent,Vacataire,Stagiaire',
            'diplome_academique_plus_eleve' => 'required|string|max:255',
            'intitule_diplome' => 'required|string|max:255',
            'universite_obtention' => 'nullable|string|max:255',
            'annee_obtention_diplome' => 'nullable|digits:4|integer',
            'diplome_professionnel' => 'nullable|string|max:255',
            'lieu_obtention_diplome_professionnel' => 'nullable|string|max:255',
            'annee_obtention_diplome_professionnel' => 'nullable|digits:4|integer',
            'nom_epoux_ou_epouse' => 'nullable|string|max:255',
            'contact_epoux_ou_epouse' => 'nullable|string|max:20',
            'pp_nom' => 'required|string|max:255',
            'pp_prenom' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'pp_lien_parente' => 'required|string|max:255',
            'pp_adresse' => 'required|string|max:255',
            'pp_contact' => 'required|string|max:20',
            'date_prise_service' => 'nullable|date',
        ]);

        

       // Création du personnel (sans matricule au début)
        $personnel = new Personnels();
        $personnel->poste_id = $request->poste_id;
        $personnel->nom = $request->nom;
        $personnel->prenom = $request->prenom;
        $personnel->contact = $request->contact;
        $personnel->email = $request->email;
        $personnel->date_naissance = $request->date_naissance;
        $personnel->lieu_naissance = $request->lieu_naissance;
        $personnel->prefecture_naissance = $request->prefecture_naissance;
        $personnel->sexe = $request->sexe;
        $personnel->quartier_residentiel = $request->quartier_residentiel;
        $personnel->situation_familiale = $request->situation_familiale;
        $personnel->nombre_enfants = $request->nombre_enfants;
        $personnel->situation_agent = $request->situation_agent;
        $personnel->diplome_academique_plus_eleve = $request->diplome_academique_plus_eleve;
        $personnel->intitule_diplome = $request->intitule_diplome;
        $personnel->universite_obtention = $request->universite_obtention;
        $personnel->annee_obtention_diplome = $request->annee_obtention_diplome;
        $personnel->diplome_professionnel = $request->diplome_professionnel;
        $personnel->lieu_obtention_diplome_professionnel = $request->lieu_obtention_diplome_professionnel;
        $personnel->annee_obtention_diplome_professionnel = $request->annee_obtention_diplome_professionnel;
        $personnel->nom_epoux_ou_epouse = $request->nom_epoux_ou_epouse;
        $personnel->contact_epoux_ou_epouse = $request->contact_epoux_ou_epouse;
        $personnel->date_prise_service = $request->date_prise_service;
        $personnel->mot_de_passe = Hash::make($request->mot_de_passe);

        $personnel->etat = 1;
        $personnel->statut = 'actif';

        // Upload de la photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos_personnels', 'public');
            $personnel->photo = $photoPath;
        }

        // D'abord on sauvegarde pour générer l'ID
        $personnel->save();

        // Génération du matricule unique (ex: EIM00001)
        $matricule = 'EIM' . str_pad($personnel->id, 5, '0', STR_PAD_LEFT);
        $personnel->matricule = $matricule;

        // Génération du QR code
        $qrContent = "Matricule: {$personnel->matricule}, Nom: {$personnel->nom}, Prénom: {$personnel->prenom}";
        $qrPath = 'qrcodes/personnel_' . $personnel->id . '.svg';
        QrCode::format('svg')->size(300)->generate($qrContent, storage_path('app/public/' . $qrPath));
        $personnel->qr_code = $qrPath;

        // Mise à jour finale avec matricule et QR code
        $personnel->save();

        
        // Selon le type de personnel
        $typePersonnel = $request->input('type_personnel');
            if ($request->type_personnel === 'administratif') {
                $request->validate([
                    'admin_fonction_occupee' => 'required|string',
                    'admin_service' => 'required|string',
                ]);

                PersonnelsAdministratif::create([
                    'fonction_occupee' => $request->admin_fonction_occupee,
                    'service' => $request->admin_service,
                    'personnel_id' => $personnel->id,
                ]);
            } elseif ($request->type_personnel === 'enseignant') {
                $request->validate([
                    'enseignant_dominante' => 'required|string',
                    'enseignant_volume_horaire' => 'required|integer|min:0',
                    'enseignant_classe_intervention' => 'required|string',
                ]);

                $poste = Poste::find($request->poste_id);

                $salaire_total = $request->enseignant_volume_horaire * $poste->salaire_horaire;

                PersonnelsEnseignant::create([
                    'dominante' => $request->enseignant_dominante,
                    'sous_dominante' => $request->enseignant_sous_dominante,
                    'volume_horaire' => $request->enseignant_volume_horaire,
                    'classe_intervention' => $request->enseignant_classe_intervention,
                    'personnel_id' => $personnel->id,
                    'salaire_total' => $salaire_total,
                ]);
            }

        
          // Enregistrement de la personne à prévenir
          $personneAPrevenir = PersonnesAPrevenir::create([
            'nom' => $request->pp_nom,
            'prenom' => $request->pp_prenom,
            'profession' => $request->profession,
            'lien_parente' => $request->pp_lien_parente,
            'adresse' => $request->pp_adresse,
            'contact' => $request->pp_contact,
            'etat' => 1,
            'personnel_id' => $personnel->id
        ]);


        return redirect()->back()->with('success', 'Le personnel a été ajouté avec succès.');
    }
    
   
    public function desactiver($id)
    {
        try {
            $personnel = Personnel::findOrFail($id);
            $personnel->etat = 2;
            $personnel->save();
    
            return response()->json(['message' => 'Personnel désactivé avec succès.']);
        } catch (\Exception $e) {
            // Log l’erreur pour la retrouver facilement
            \Log::error('Erreur lors de la désactivation du personnel : ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la désactivation.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $personnels = Personnels::findOrFail($id);
            $personnels->etat = 2;
            $personnels->save();

            return response()->json(['success' => true, 'message' => 'Personnel supprimé avec succès.']);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression du personnel : ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression.'], 500);
        }
    }

    public function edit($id)
    {
        $personnel = Personnels::with(['enseignant', 'administratif','personneAPrevenir'])->findOrFail($id);

        if (!$personnel) {
            return response()->json(['message' => 'Personnel non trouvé'], 404);
        }

        return response()->json($personnel);
    }

    public function update(Request $request)
    {
        $personnel = Personnels::findOrFail($request->input('personnel_id'));

        // Mettre à jour les champs généraux
        $personnel->nom = $request->nom;
        $personnel->prenom = $request->prenom;
        $personnel->email = $request->email;
        $personnel->contact = $request->contact;
        $personnel->date_naissance = $request->date_naissance;
        $personnel->lieu_naissance = $request->lieu_naissance;
        $personnel->prefecture_naissance = $request->prefecture_naissance;
        $personnel->sexe = $request->sexe;
        $personnel->quartier_residentiel = $request->quartier_residentiel;
        $personnel->situation_familiale = $request->situation_familiale;
        $personnel->nombre_enfants = $request->nombre_enfants;
        $personnel->situation_agent = $request->situation_agent;
        $personnel->diplome_academique_plus_eleve = $request->diplome_academique_plus_eleve;
        $personnel->intitule_diplome = $request->intitule_diplome;
        $personnel->universite_obtention = $request->universite_obtention;
        $personnel->annee_obtention_diplome = $request->annee_obtention_diplome;
        $personnel->diplome_professionnel = $request->diplome_professionnel;
        $personnel->lieu_obtention_diplome_professionnel = $request->lieu_obtention_diplome_professionnel;
        $personnel->annee_obtention_diplome_professionnel = $request->annee_obtention_diplome_professionnel;
        $personnel->anciennete = $request->anciennete;
        $personnel->nom_epoux_ou_epouse = $request->nom_epoux_ou_epouse;
        $personnel->contact_epoux_ou_epouse = $request->contact_epoux_ou_epouse;
        $personnel->date_prise_service = $request->date_prise_service;
       
        $personnel->statut = 'actif';
        $personnel->save();

        // Mettre à jour la personne à prévenir (si elle existe)
        if ($personnel->personne_a_prevenir) {
            $personne = $personnel->personne_a_prevenir;
        } else {
            $personne = new PersonnesAPrevenir();
            $personne->personnel_id = $personnel->id;
        }

        $personne->nom = $request->p_nom;
        $personne->prenom = $request->p_prenom;
        $personne->profession = $request->p_profession;
        $personne->lien_parente = $request->p_lien_parente;
        $personne->adresse = $request->p_adresse;
        $personne->contact = $request->p_contact;
        $personne->save();

        // Enregistrer les données du type de personnel
        if ($request->type_personnel === 'administratif') {
            // Supprimer enseignant si existant
            $personnel->enseignant()?->delete();

            $admin = $personnel->administratif ?? new PersonnelsAdministratif();
            $admin->personnel_id = $personnel->id;
            $admin->fonction_occupee = $request->fonction_occupee;
            $admin->service = $request->service;
            $admin->save();

        } elseif ($request->type_personnel === 'enseignant') {
            // Supprimer administratif si existant
            $personnel->administratif()?->delete();

            $enseignant = $personnel->enseignant ?? new PersonnelsEnseignant();
            $enseignant->personnel_id = $personnel->id;
            $enseignant->dominante = $request->dominante;
            $enseignant->sous_dominante = $request->sous_dominante;
            $enseignant->volume_horaire = $request->volume_horaire;
            $enseignant->classe_intervention = $request->classe_intervention;
            $enseignant->save();
        } else {
            // Supprimer les deux si aucun type n'est sélectionné
            $personnel->administratif()?->delete();
            $personnel->enseignant()?->delete();
        }

        return response()->json(['message' => 'Mise à jour réussie']);
    }

    



    public function fiche($id)
    {
        $personnel = Personnels::with([
            'enseignant', 
            'administratif', 
            'personneAPrevenir', 
            'documents',
            'poste',
            'contrats',
            'remuneration.primes',
            'remuneration.retenues',
            'banque', 
            'billetage',
            'pointages' 
        ])->findOrFail($id);

        $documents = $personnel->documents;

        // Récupérer le contrat le plus récemment créé ou modifié
        $dernierContrat = $personnel->contrats->sortByDesc(function ($contrat) {
            return $contrat->updated_at > $contrat->created_at ? $contrat->updated_at : $contrat->created_at;
        })->first();

        // Début du bloc ajouté : génération du bilan des 30 jours ouvrés


        $periode = CarbonPeriod::create(
            now()->subDays(30)->startOfDay(),
            now()->startOfDay()
        );

        $joursOuvres = collect();
        foreach ($periode as $date) {
            if ($date->isWeekday()) {
                $joursOuvres->push($date->copy());
            }
        }

        $pointagesComplets = $joursOuvres->map(function ($jour) use ($personnel) {
            $pointage = $personnel->pointages()
                ->whereDate('date', $jour->toDateString())
                ->first();

            return [
                'date' => $jour->copy(),
                'heure_arrivee' => $pointage->heure_arrivee ?? null,
                'heure_depart' => $pointage->heure_depart ?? null,
            ];
        })->sortByDesc('date');
        //  Fin du bloc ajouté

        return view('personnel.fiche', compact(
            'personnel',
            'documents',
            'dernierContrat',
            'pointagesComplets' // On envoie ce tableau à la vue
        ));
    }





        
            public function TelechargerDocument($id)
            {
                $document = Document::with('personnel')->findOrFail($id);

                $chemin = $document->fichier;
                $nom = $document->personnel->nom . '_' . $document->personnel->prenom . '_' . $document->libelle;
                $nom = str_replace(' ', '_', $nom);
                $nom .= '.' . pathinfo($chemin, PATHINFO_EXTENSION);

                return Storage::disk('public')->download($chemin, $nom);
            }



            public function TelechargerContrat($id)
            {
                $contrat = Contrat::with('personnel')->findOrFail($id);

                $chemin = public_path($contrat->fichier); 
                $nom = $contrat->personnel->nom . '_' . $contrat->personnel->prenom . '_Contrat';
                $nom = str_replace(' ', '_', $nom);
                $nom .= '.' . pathinfo($chemin, PATHINFO_EXTENSION);

                
                if (!file_exists($chemin)) {
                    abort(404, 'Fichier non trouvé.');
                }

                return response()->download($chemin, $nom);
            }





        public function choisirFinancement(Request $request, $id)
        {
            $request->validate([
                'type_financement' => 'required|in:billetage,banque',
            ]);

            $personnel = Personnels::findOrFail($id);

            // Supprimer tout mode existant avant d'enregistrer le nouveau
            $personnel->billetage()?->delete();
            $personnel->banque()?->delete();

            if ($request->type_financement === 'billetage') {
                \App\Models\Billetage::create([
                    'personnel_id' => $personnel->id,
                    'statut' => 'actif',
                    'etat' => 1, 
                ]);
            } elseif ($request->type_financement === 'banque') {
                $request->validate([
                    'nom' => 'required|string|max:255',
                    'numero_compte' => 'required|string|max:255',
                ]);

                \App\Models\Banque::create([
                    'personnel_id' => $personnel->id,
                    'nom' => $request->nom,
                    'numero_compte' => $request->numero_compte,
                    'etat' => 1,
                ]);
            }

            
            return redirect()->back()->with('success', 'Mode de financement mis à jour.');

        }





}
