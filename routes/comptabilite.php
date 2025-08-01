<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\CaissierController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\CantineOffreController;
use App\Http\Controllers\CantineAchatController;
use App\Http\Controllers\CantineInscriptionController;
use App\Http\Controllers\CantineFournisseurController;
use App\Http\Controllers\CantineMenuController;
use App\Http\Controllers\CantineMouvementController;
use App\Http\Controllers\BusInscriptionController;
use App\Http\Controllers\BusLigneController;
use App\Http\Controllers\BusVoitureController;
use App\Http\Controllers\BusChauffeurController;


// MENU INSCRIPTION 

// 📂 Inscriptions 

Route::get('/inscriptions/liste', [InscriptionController::class, 'liste'])->name('admin_inscriptions_liste');
Route::get('/inscriptions/recherche', [InscriptionController::class, 'rechercher'])->name('admin_inscriptions_rechercher');
Route::post('/inscriptions/recherche', [InscriptionController::class, 'valider_recherche'])->name('admin_inscriptions_valider_rechercher');
Route::get('/inscriptions/modifier/{id}', [InscriptionController::class, 'show'])->name('admin_inscriptions_edit');
Route::post('/inscriptions/update/{id}', [InscriptionController::class, 'update'])->name('admin_inscriptions_update');


      // 📂 Cantines Inscription


    Route::get('/cantines/inscriptions/liste', [CantineInscriptionController::class, 'liste'])->name('admin_cantine_liste');
    Route::get('/cantines/inscriptions/telechargement', [CantineInscriptionController::class, 'telecharger'])->name('admin_cantine_telecharger');   

        Route::get('/cantines/inscriptions/detail/{id}', [CantineInscriptionController::class, 'detail'])->name('admin_cantine_inscription_detail');



//MENU PAIEMENT 
// 📂 Paiements 


Route::get('/paiements/liste', [PaiementController::class, 'mespaiements'])->name('admin_paiement_mespaiements');

Route::get('/paiements/tous', [PaiementController::class, 'touspaiements'])->name('admin_paiement_tous');

Route::get('/paiements/enregister', [PaiementController::class, 'afficher'])->name('admin_paiement_afficher');

Route::post('/paiements/enregister', [PaiementController::class, 'valider'])->name('admin_paiement_valider');
);
Route::post('/paiements/supprimer/{id}', [PaiementController::class, 'supprimer'])->name('admin_paiement_supprimer');
Route::post('/paiements/annuler/{id}', [PaiementController::class, 'annuler'])->name('admin_paiement_annuler');
Route::post('/paiements/demander/{id}', [PaiementController::class, 'demander'])->name('admin_paiement_demander');
Route::get('/paiements/encaisser/{id}', [PaiementController::class, 'afficherEncaissement'])->name('admin_paiement_afficher_encaissement');
Route::post('/paiements/encaisser/{id}', [PaiementController::class, 'valider_encaissement'])->name('admin_paiement_valider_encaissement');

Route::get('/paiements/imprimer/{id}', [PaiementController::class, 'imprimer'])->name('admin_paiement_imprimer');



// 📂 Caisses 

Route::get('/caisses/generer', [CaisseController::class, 'generer'])->name('admin_caisse_generer');
Route::post('/caisses/creer', [CaisseController::class, 'creer'])->name('admin_caisse_creer');
Route::get('/caisses/modifier/{id}', [CaisseController::class, 'modifier'])->name('admin_caisse_modifier');
Route::post('/caisses/miseajour/{id}', [CaisseController::class, 'miseajour'])->name('admin_caisse_miseajour');
Route::get('/caisses/cloturer/{id}', [CaisseController::class, 'cloturer'])->name('admin_caisse_cloturer');
Route::post('/caisses/cloturer/{id}', [CaisseController::class, 'valider_cloturer'])->name('admin_cloturer_valider');
Route::post('/caisses/generer/caissier', [CaisseController::class, 'genererCaissier'])->name('admin_generer_caissier');



         // 📂 Reporting 


     Route::get('/reportings/paiement', [ReportingController::class, 'paiement'])->name('admin_reporting_paiement');
    Route::get('/reportings/prevision', [ReportingController::class, 'prevision'])->name('admin_reporting_prevision');




// PARAMETRES 


// 📂 Niveaux 

    Route::get('/niveaux/index', [NiveauController::class, 'index'])->name('admin_niveau_index');
    Route::post('/niveaux/save', [NiveauController::class, 'store'])->name('admin_niveau_store');
    Route::get('/niveaux/modifier/{id}', [NiveauController::class, 'edit'])->name('admin_niveau_edit');
    Route::post('/niveaux/update/{id}', [NiveauController::class, 'update'])->name('admin_niveau_update');
    Route::post('/niveaux/delete/{id}', [NiveauController::class, 'delete'])->name('admin_niveau_delete');


// 📂 Cycle 

    Route::get('/cycles/index', [CycleController::class, 'index'])->name('admin_cycle_index');
    Route::post('/cycles/save', [CycleController::class, 'store'])->name('admin_cycle_store');
    Route::get('/cycles/modifier/{id}', [CycleController::class, 'edit'])->name('admin_cycle_edit');
    Route::post('/cycles/update/{id}', [CycleController::class, 'update'])->name('admin_cycle_update');
    Route::post('/cycles/delete/{id}', [CycleController::class, 'delete'])->name('admin_cycle_delete');


    // 📂 Frais ecole 

    Route::get('/fraisecoles/index', [FraisEcoleController::class, 'index'])->name('admin_fraisecoles_index');
    Route::post('/fraisecoles/save', [FraisEcoleController::class, 'store'])->name('admin_fraisecoles_store');
    Route::get('/fraisecoles/modifier/{id}', [FraisEcoleController::class, 'edit'])->name('admin_fraisecoles_edit');
    Route::post('/fraisecoles/update/{id}', [FraisEcoleController::class, 'update'])->name('admin_fraisecoles_update');
    Route::post('/fraisecoles/delete/{id}', [FraisEcoleController::class, 'delete'])->name('admin_fraisecoles_delete');


     // 📂 Annee scolaires 

    Route::get('/annees/index', [AnneeController::class, 'index'])->name('admin_annees_index');
    Route::post('/annees/save', [AnneeController::class, 'store'])->name('admin_annees_store');
    Route::get('/annees/modifier/{id}', [AnneeController::class, 'edit'])->name('admin_annees_edit');
    Route::post('/annees/update/{id}', [AnneeController::class, 'update'])->name('admin_annees_update');
    Route::post('/annees/delete/{id}', [AnneeController::class, 'delete'])->name('admin_annees_delete');



    // 📂 Classes  

    Route::get('/classes/index', [ClasseController::class, 'index'])->name('admin_classe_index');
    Route::post('/classes/save', [ClasseController::class, 'store'])->name('admin_classe_store');
    Route::get('/classes/modifier/{id}', [ClasseController::class, 'edit'])->name('admin_classe_edit');
    Route::post('/classes/update/{id}', [ClasseController::class, 'update'])->name('admin_classe_update');
    Route::post('/classes/delete/{id}', [ClasseController::class, 'delete'])->name('admin_classe_delete');
   Route::get('/classes/constituer', [ClasseController::class, 'constituer'])->name('admin_classe_constituer');

     Route::post('/classes/constituer', [ClasseController::class, 'validerClasse'])->name('admin_classe_valider');

    Route::get('/classes/details/{id}', [ClasseController::class, 'detail'])->name('admin_classe_detail');


    

      // CANTINES 

      // 📂 Cantines Offre 

    Route::get('/cantines/offres/index', [OffreController::class, 'offre'])->name('admin_cantine_offre');
     Route::post('/cantines/offres/ajouter', [OffreController::class, 'ajouter'])->name('admin_cantine_offre_ajouter');
     Route::get('/cantines/offres/{id}', [OffreController::class, 'modifier'])->name('admin_cantine_offre_modifier');
      Route::post('/cantines/offres/update/{id}', [OffreController::class, 'update'])->name('admin_cantine_offre_update');
    Route::post('/cantines/offres/delete/{id}', [OffreController::class, 'delete'])->name('admin_cantine_offre_delete');
    Route::get('/cantines/offres/detail/{id}', [OffreController::class, 'detail'])->name('admin_cantine_offre_detail');


 // 📂 Cantines fournisseurs

    Route::get('/cantines/fournisseurs/index', [FournisseurController::class, 'liste'])->name('admin_cantine_fournisseurs');
     Route::post('/cantines/fournisseurs/ajouter', [FournisseurController::class, 'ajouter'])->name('admin_cantine_fournisseurs_ajouter');
     Route::get('/cantines/fournisseurs/{id}', [FournisseurController::class, 'modifier'])->name('admin_cantine_fournisseurs_modifier');
      Route::post('/cantines/fournisseurs/update/{id}', [FournisseurController::class, 'update'])->name('admin_cantine_fournisseurs_update');
    Route::post('/cantines/fournisseurs/delete/{id}', [FournisseurController::class, 'delete'])->name('admin_cantine_fournisseurs_delete');
    Route::get('/cantines/fournisseurs/detail/{id}', [FournisseurController::class, 'detail'])->name('admin_cantine_fournisseurs_detail');



    // 📂 Cantine  Achats  


    Route::get('/cantines/achats/index', [AchatController::class, 'index'])->name('admin_cantines_achats_index');
    Route::post('/cantines/achats/ajouter', [AchatController::class, 'ajouter'])->name('admin_cantines_achats_ajouter');
     Route::get('/cantines/achats/modifier/{id}', [AchatController::class, 'modifier'])->name('admin_cantines_achats_modifier');
      Route::post('/cantines/achats/update/{id}', [AchatController::class, 'update'])->name('admin_cantines_achats_update');
    Route::post('/cantines/achats/delete/{id}', [AchatController::class, 'delete'])->name('admin_cantines_achats_delete');
    Route::get('/cantines/achats/detail/{id}', [AchatController::class, 'detail'])->name('admin_cantines_achats_detail');


     // 📂 Cantine  Magasins   


    Route::get('/cantines/magasins/index', [MagasinController::class, 'index'])->name('admin_cantines_magasins_index');
    Route::post('/cantines/magasins/ajouter', [MagasinController::class, 'ajouter'])->name('admin_cantines_magasins_ajouter');
     Route::get('/cantines/magasins/modifier/{id}', [MagasinController::class, 'modifier'])->name('admin_cantines_magasins_modifier');
      Route::post('/cantines/magasins/update/{id}', [MagasinController::class, 'update'])->name('admin_cantines_magasin_update');
    Route::post('/cantines/magasins/delete/{id}', [MagasinController::class, 'delete'])->name('admin_cantines_magasins_delete');
    Route::get('/cantines/magasins/detail/{id}', [MagasinController::class, 'detail'])->name('admin_cantines_magasins_detail');

// 📂 Cantine  stocks   


    Route::get('/cantines/stocks/index', [StockController::class, 'index'])->name('admin_cantines_stocks_index');
    Route::post('/cantines/stocks/ajouter', [StockController::class, 'ajouter'])->name('admin_cantines_stocks_ajouter');
     Route::get('/cantines/stocks/modifier/{id}', [StockController::class, 'modifier'])->name('admin_cantines_stocks_modifier');
      Route::post('/cantines/stocks/update/{id}', [StockController::class, 'update'])->name('admin_cantines_stocks_update');
    Route::post('/cantines/stocks/delete/{id}', [StockController::class, 'delete'])->name('admin_cantines_stocks_delete');




// 📂 Cantine  Bons    


    Route::get('/cantines/bons/index', [BonController::class, 'index'])->name('admin_bons_index');
    Route::post('/cantines/bons/ajouter', [BonController::class, 'ajouter'])->name('admin_bons_ajouter');
     Route::get('/cantines/bons/modifier/{id}', [BonController::class, 'modifier'])->name('admin_bons_modifier');
      Route::post('/cantines/bons/update/{id}', [BonController::class, 'update'])->name('admin_bons_update');
    Route::post('/cantines/stocks/delete/{id}', [BonController::class, 'delete'])->name('admin_bons_delete');



// MENU BUS 
   


     // 📂 Bus  Inscriptions 


    Route::get('/bus/inscrits/liste', [BusInscriptionController::class, 'liste'])->name('admin_bus_liste_inscrits');
     Route::get('/bus/inscrits/detail/{id}', [BusInscriptionController::class, 'detail'])->name('admin_bus_inscriptions_detail');


 // 📂 Bus  Lignes 

    Route::get('/bus/lignes/index', [BusLigneController::class, 'index'])->name('admin_bus_lignes_index');
    Route::post('/bus/lignes/ajouter', [BusLigneController::class, 'ajouter'])->name('admin_bus_ligne_ajouter');
     Route::get('/bus/lignes/modifier/{id}', [BusLigneController::class, 'modifier'])->name('admin_bus_ligne_modifier');
      Route::post('/bus/lignes/update/{id}', [BusLigneController::class, 'update'])->name('admin_bus_ligne_update');
    Route::post('/bus/lignes/delete/{id}', [BusLigneController::class, 'delete'])->name('admin_bus_ligne_delete');
    Route::get('/bus/lignes/detail/{id}', [BusLigneController::class, 'detail'])->name('admin_bus_ligne_detail');
    Route::get('/bus/lignes/affecter', [BusLigneController::class, 'affecter'])->name('admin_bus_ligne_affecter');
    Route::post('/bus/lignes/affecter', [BusLigneController::class, 'valider_affecter'])->name('admin_bus_ligne_valider_affecter');


     // 📂 Bus  Voitures  


    Route::get('/bus/voitures/index', [BusVoitureController::class, 'index'])->name('admin_bus_voitures_index');
    Route::post('/bus/lignes/ajouter', [BusVoitureController::class, 'ajouter'])->name('admin_bus_voitures_ajouter');
     Route::get('/bus/voitures/modifier/{id}', [BusVoitureController::class, 'modifier'])->name('admin_bus_voitures_modifier');
      Route::post('/bus/voitures/update/{id}', [BusVoitureController::class, 'update'])->name('admin_bus_voitures_update');
    Route::post('/bus/voitures/delete/{id}', [BusVoitureController::class, 'delete'])->name('admin_bus_voitures_delete');
    Route::get('/bus/voitures/detail/{id}', [BusVoitureController::class, 'detail'])->name('admin_bus_voitures_detail');


     // 📂 Bus  Chauffeurs   


    Route::get('/bus/chauffeurs/index', [BusChauffeurController::class, 'index'])->name('admin_bus_chauffeurs_index');
    Route::post('/bus/chauffeurs/ajouter', [BusChauffeurController::class, 'ajouter'])->name('admin_bus_chauffeurs_ajouter');
     Route::get('/bus/chauffeurs/modifier/{id}', [BusChauffeurController::class, 'modifier'])->name('admin_bus_chauffeurs_modifier');
      Route::post('/bus/chauffeurs/update/{id}', [BusChauffeurController::class, 'update'])->name('admin_bus_chauffeurs_update');
    Route::post('/bus/chauffeurs/delete/{id}', [BusChauffeurController::class, 'delete'])->name('admin_bus_chauffeurs_delete');
    Route::get('/bus/chauffeurs/detail/{id}', [BusChauffeurController::class, 'detail'])->name('admin_bus_chauffeurs_detail');