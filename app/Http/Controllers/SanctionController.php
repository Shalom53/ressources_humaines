<?php

namespace App\Http\Controllers;
use App\Models\TypeSanction;
use App\Models\Sanction;
use Illuminate\Http\Request;
use App\Models\Personnels;

class SanctionController extends Controller
{
    //

    public function Sanctions()
    {
        $sanctions = Sanction::with('personnel')->where('etat', 1)->get();
        $personnels = Personnels::where('etat', 1)->get();
        $typeSanctions = TypeSanction::where('etat', 1)->get();

        return view('Sanctions.ListeSanctions', compact('sanctions', 'personnels', 'typeSanctions'));
    }
    
    public function storeSanctions(Request $request)
    {
        
        $request->validate([
            'type_id' => 'required|exists:type_sanctions,id',  
            'motif' => 'required|string|max:255', 
            'date_debut' => 'required|date', 
            'date_fin' => 'required|date|after_or_equal:date_debut',  
            'personnel_id' => 'nullable|exists:personnels,id', 
        ]);

        $typeSanction = TypeSanction::find($request->type_id);
        $sanction = new Sanction();
        $sanction->motif = $request->motif;
        $sanction->date_debut = $request->date_debut;
        $sanction->date_fin = $request->date_fin;
        $sanction->type = $typeSanction->nom;
        $sanction->personnel_id = $request->personnel_id;
        $sanction->save();  

       
        return redirect()->back()->with('success', 'Sanction ajoutée avec succès');
    }

    public function modifierSanctions(Request $request, $id)
    {
        
        $validatedData = $request->validate([
            'type_id' => 'required|exists:type_sanctions,id',
            'motif' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'personnel_id' => 'required|exists:personnels,id',
        ]);

        
        $sanction = Sanction::findOrFail($id);

        
        $sanction->type_id = $validatedData['type_id'];
        $sanction->motif = $validatedData['motif'];
        $sanction->date_debut = $validatedData['date_debut'];
        $sanction->date_fin = $validatedData['date_fin'];
        $sanction->personnel_id = $validatedData['personnel_id'];

        $sanction->save();

        
        return response()->json([
            'success' => true,
            'message' => 'La sanction a été modifiée avec succès.'
        ]);
    }


    public function TypeSanctions()
    {
        $typeSanctions = TypeSanction::where('etat', 1)->get();
        return view('Sanctions.TypeSanctions', compact('typeSanctions'));
    }
    


    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'reduction' => 'required|numeric|min:0|max:100',
        ]);
    
        TypeSanction::create([
            'nom' => $request->nom,
            'reduction' => $request->reduction,
        ]);
    
       
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Type de sanction ajouté avec succès.'
            ]);
        }
    
       
        return redirect()->back()->with('success', 'Type de sanction ajouté avec succès.');
    }
    

    public function modifierSanction(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'reduction' => 'required|numeric|min:0|max:100', // Validation de la réduction, entre 0 et 100
        ]);

        $typeSanction = TypeSanction::findOrFail($id);
        $typeSanction->nom = $validatedData['nom'];
        $typeSanction->reduction = $validatedData['reduction'];
        $typeSanction->save();
        return response()->json([
            'success' => true,
            'message' => 'Le type de sanction a été modifié avec succès.'
        ]);
    }


    public function SupprimerTypeSanction($id)
    {
        $typeSanction = TypeSanction::findOrFail($id);
        $typeSanction->etat = 2;
        $typeSanction->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Le type de sanction a été supprimé avec succès.'
        ]);
    }
    

}
