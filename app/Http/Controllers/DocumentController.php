<?php

namespace App\Http\Controllers;
use App\Models\Personnels;
use App\Models\Poste;
use App\Models\Document;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    //


    public function liste()
    {
        // Récupération des personnels avec leur poste et le nombre de documents actifs (état = 1)
        $personnels = Personnels::with('poste')
            ->where('etat', 1)
            ->withCount([
                'documents' => function ($query) {
                    $query->where('etat', 1); // on compte seulement les documents actifs
                }
            ])
            ->get();

        // Retourner la vue avec les données
        return view('informations.documents', compact('personnels'));
    }

    public function ajouter(Request $request)
    {
        $request->validate([
            'personnel_id' => 'required|exists:personnels,id',
            'libelle' => 'nullable|string',
            'fichier' => 'required|file|max:10240', // 10 Mo max
        ]);

        $path = $request->file('fichier')->store('documents', 'public');

        Document::create([
            'personnel_id' => $request->personnel_id,
            'libelle' => $request->libelle,
            'fichier' => $path,
        ]);

       return redirect()->back()->with([
        'document_ajoute' => true,
        'libelle' => $request->libelle,
         ]);

    }

    public function documentsParPersonnel($id)
    {
        $documents = Document::where('personnel_id', $id)
            ->where('etat', 1)
            ->select('id', 'libelle', 'fichier')
            ->get();

        return response()->json($documents);
    }




 

    public function telecharger($id)
    {
        $document = Document::with('personnel')->findOrFail($id);

        $chemin = $document->fichier;
        $nom = $document->personnel->nom . '_' . $document->personnel->prenom . '_' . $document->libelle;
        $nom = str_replace(' ', '_', $nom);
        $nom .= '.' . pathinfo($chemin, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($chemin, $nom);
    }

    public function supprimer($id)
    {
        $document = Document::findOrFail($id);
        $document->etat = 2;
        $document->save();

        return response()->json([
            'message' => 'Le document a été supprimé avec succès.'
        ]);
    }

    public function show($id)
    {
        $document = Document::findOrFail($id);
        return response()->json($document);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:documents,id',
            'libelle' => 'required|string|max:255',
            'fichier' => 'nullable|file',
        ]);

        $document = Document::findOrFail($request->id);
        $document->libelle = $request->libelle;

        // Si un nouveau fichier est uploadé
        if ($request->hasFile('fichier')) {
            // Supprimer l'ancien fichier s'il existe
            if ($document->fichier && Storage::disk('public')->exists($document->fichier)) {
                Storage::disk('public')->delete($document->fichier);
            }

            // Stocker le nouveau fichier
            $chemin = $request->file('fichier')->store('documents', 'public');
            $document->fichier = $chemin;
        }

        $document->save();

        return response()->json(['message' => 'Document modifié avec succès.']);
    }


}
