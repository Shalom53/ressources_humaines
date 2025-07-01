<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeEmploi;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DemandeEmploiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|regex:/^[a-zA-ZÀ-ÿ\s-]+$/|max:255',
            'prenom' => 'required|string|regex:/^[a-zA-ZÀ-ÿ\s-]+$/|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
            'experience' => 'nullable|integer|min:0',
            'domaine' => 'required|string|max:255',
            'cv' => 'required|file|mimes:pdf|max:2048',
            'lettre_motivation' => 'required|file|mimes:pdf|max:2048',
        ], [
            'nom.regex' => 'Le nom doit contenir uniquement des caractères alphabétiques.',
            'prenom.regex' => 'Le prénom doit contenir uniquement des caractères alphabétiques.',
            'cv.mimes' => 'Le CV doit être un fichier PDF.',
            'lettre_motivation.mimes' => 'La lettre de motivation doit être un fichier PDF.',
        ]);

        // Stocker les fichiers
        $cvPath = $request->file('cv')->store('cvs', 'public');
        $lettrePath = $request->file('lettre_motivation')->store('lettres', 'public');

        // Enregistrer la demande dans la base de données
        DemandeEmploi::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'experience' => $request->experience ?? 0,
            'domaine' => $request->domaine,
            'cv' => $cvPath,
            'lettre_motivation' => $lettrePath,
        ]);

        return redirect()->back()->with('success', 'Votre demande a été envoyée avec succès !');
    }


    public function index()
    {
        // Récupère toutes les demandes depuis la base de données
        $demandes = DemandeEmploi::orderBy('created_at', 'desc')->get();

        // Retourne la vue avec les données
        return view('Demandes_d_emploies.index', compact('demandes'));

    }



        public function telechargerDossier($id)
        {
            $DemandeEmploi = DemandeEmploi::findOrFail($id);

            $zipFileName = 'dossier_' . $DemandeEmploi->nom . '_' . $DemandeEmploi->prenom . '.zip';
            $zipPath = storage_path('app/public/temp/' . $zipFileName);

            // Crée un dossier temporaire s'il n'existe pas
            if (!file_exists(storage_path('app/public/temp'))) {
                mkdir(storage_path('app/public/temp'), 0755, true);
            }

            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                $zip->addFile(storage_path('app/public/' . $DemandeEmploi->cv), 'CV_' . $DemandeEmploi->nom . '.pdf');
                $zip->addFile(storage_path('app/public/' . $DemandeEmploi->lettre_motivation), 'Lettre_Motivation_' . $DemandeEmploi->nom . '.pdf');
                $zip->close();
            }

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

}


