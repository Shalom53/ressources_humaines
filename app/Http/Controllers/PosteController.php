<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use Illuminate\Http\Request;



class PosteController extends Controller
{
    
    public function index()
    {
        $postes = Poste::where('etat', 1)->get();
        return view('postes.liste', compact('postes'));
    }

   
   public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type_personnel' => 'required|in:administratif,enseignant',
            'salaire_base' => 'nullable|numeric',
            'salaire_horaire' => 'nullable|numeric',
        ]);

        $poste = new Poste();
        $poste->nom = $request->nom;

        if ($request->type_personnel === 'administratif') {
            $poste->salaire_base = $request->salaire_base;
            $poste->salaire_horaire = 0;
        } elseif ($request->type_personnel === 'enseignant') {
            $poste->salaire_base = 0;
            $poste->salaire_horaire = $request->salaire_horaire;
        }

        $poste->etat = 1;
        $poste->save();

        return redirect()->back()->with('success', 'Poste ajouté avec succès.');
    }

 
    public function modifierPoste(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'type_personnel' => 'required|in:administratif,enseignant',
            'salaire_base' => 'nullable|numeric',
            'salaire_horaire' => 'nullable|numeric',
        ]);

        $poste = Poste::findOrFail($id);
        $poste->nom = $validatedData['nom'];

        if ($validatedData['type_personnel'] === 'administratif') {
            $poste->salaire_base = $validatedData['salaire_base'] ?? 0;
            $poste->salaire_horaire = 0;
        } elseif ($validatedData['type_personnel'] === 'enseignant') {
            $poste->salaire_base = 0;
            $poste->salaire_horaire = $validatedData['salaire_horaire'] ?? 0;
        }

        $poste->save();

        return response()->json([
            'success' => true,
            'message' => 'Poste modifié avec succès.'
        ]);
    }


    public function Supprimerposte($id)
    {
        $poste = Poste::findOrFail($id);
        $poste->etat = 2;
        $poste->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Poste supprimé avec succès.'
        ]);
    }
}

