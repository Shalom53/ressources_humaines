<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retenue;

class RetenueController extends Controller
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

        Retenue::create([
            'remuneration_id' => $request->remuneration_id,
            'libelle' => $request->libelle,
            'periode' => $request->periode,
            'montant' => $request->montant,
            'etat' => 1,
        ]);

        return response()->json(['message' => 'Retenue ajouter avec succès.']);
    }


    public function update(Request $request, $id)
    {
        $retenue = Retenue::findOrFail($id);
        $retenue->update($request->only('libelle', 'periode', 'montant'));

        return response()->json(['message' => 'Retenue modifiée avec succès.']);
    }


    public function changerEtat(Request $request, $id)
    {
        $retenue = Retenue::findOrFail($id);
        $retenue->etat = $request->input('etat', 2); // Par défaut on met 2
        $retenue->save();

        return response()->json(['message' => 'Retenue supprimée avec succès.']);
    }


}
