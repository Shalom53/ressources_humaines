<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemandeController extends Controller
{
    //
    public function demandepage(Request $request)
    {

            // Retourner les données à la vue
            return view('demande.index');

    }
}
