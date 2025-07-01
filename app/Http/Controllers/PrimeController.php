<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prime;

class PrimeController extends Controller
{
    /**
     * Enregistrer une nouvelle prime
     */
    public function store(Request $request)
    {
        $request->validate([
            'remuneration_id' => 'required|exists:remunerations,id',
            'libelle' => 'nullable|string|max:255',
            'periode' => 'nullable|string|max:100',
            'montant' => 'required|numeric|min:0',
        ]);

        Prime::create([
            'remuneration_id' => $request->remuneration_id,
            'libelle' => $request->libelle,
            'periode' => $request->periode,
            'montant' => $request->montant,
            'etat' => 1,
        ]);

        return response()->json(['message' => 'Prime ajouter avec succès.']);
        
    }


        public function update(Request $request, $id)
    {
        $prime = Prime::findOrFail($id);
        $prime->update($request->only('libelle', 'periode', 'montant'));

        return response()->json(['message' => 'Prime modifiée avec succès.']);
    }


    public function changerEtat(Request $request, $id)
    {
        $prime = Prime::findOrFail($id);
        $prime->etat = $request->input('etat', 2); // Par défaut on met 2
        $prime->save();

        return response()->json(['message' => 'Prime supprimée avec succès.']);
    }
}
