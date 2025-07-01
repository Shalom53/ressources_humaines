<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remuneration;

class RemunerationController extends Controller
{
    /**
     * Stocke une nouvelle rémunération (salaire brut) en base.
     */
    public function store(Request $request)
    {
        // Validation des données envoyées
        $request->validate([
            'personnel_id' => 'required|exists:personnels,id',
            'salaire_brut' => 'required|numeric|min:0',
        ]);

        // Création de la rémunération avec salaire brut uniquement
        Remuneration::create([
            'personnel_id' => $request->personnel_id,
            'salaire_brut' => $request->salaire_brut,
            'total_retenue' => null,
            'salaire_net' => null,


        ]);

        // Retour à la page précédente avec message de succès
        return response()->json(['message' => 'Salaire brut défini avec succès.']);

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'salaire_brut' => 'required|numeric|min:0',
            // Autres validations si nécessaires
        ]);

        $remuneration = Remuneration::findOrFail($id);
        $remuneration->salaire_brut = $request->input('salaire_brut');
        $remuneration->save();

        return response()->json(['message' => 'Salaire mis à jour avec succès.']);
    }

}
