<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\DemandeEmploiController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\SanctionController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\GestionDePaieController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\PrimeController;
use App\Http\Controllers\RemunerationController;
use App\Http\Controllers\RetenueController;
use App\Http\Controllers\PointageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('admin_login');
Route::get('/register', [App\Http\Controllers\LoginController::class, 'register'])->name('admin_register_user');
Route::post('/register/save', [App\Http\Controllers\UtilisateurController::class, 'store'])->name('admin_utilisateur_store');
Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('admin_logout');


Route::post('/utilisateurs/login', [App\Http\Controllers\UtilisateurController::class, 'login'])->name('utilisateur_authenticate');



Route::middleware(['admin'])->group(function () {

//-----------------  Tableau de bord admin

Route::get('/', [App\Http\Controllers\TableauController::class, 'tableau'])->name('tableau');




Route::get('/statistiques-personnel', [App\Http\Controllers\TableauController::class, 'statsEvolutionPersonnel']);
Route::get('/statistiques-presence-30-jours', [App\Http\Controllers\TableauController::class, 'statistiquesPresence30Jours']);






Route::get('/voir-demande-demploi', [DemandeEmploiController::class, 'index'])->name('demandes.voir');
Route::get('/telecharger-dossier/{id}', [DemandeEmploiController::class, 'telechargerDossier'])->name('telecharger.dossier');


Route::get('/Liste-Du-Personnel', [PersonnelController::class,'ListeDuPersonnel'])->name('ListeDuPersonnel');
Route::get('/ListeAdministratif', [PersonnelController::class,'ListeAdministratif'])->name('ListeAdministratif');
Route::get('/ListeEnseignant', [PersonnelController::class,'ListeEnseignant'])->name('ListeEnseignant');
Route::get('/AjouterPersonnel', [PersonnelController::class,'AjoutDuPersonnel'])->name('AjoutPersonnel');
Route::post('/enregistrerPersonnel', [PersonnelController::class, 'enregistrerPersonnel'])->name('enregistrerPersonnel');

Route::get('/personnel/{id}/edit', [PersonnelController::class, 'edit']);

Route::post('/personnel/update', [PersonnelController::class, 'update'])->name('personnel.update');




Route::get('/personnels/{id}/details', [PersonnelController::class, 'details']);
Route::post('/personnel/desactiver/{id}', [PersonnelController::class, 'desactiver'])->name('personnel.desactiver');

Route::post('/personnel/delete/{id}', [PersonnelController::class, 'destroy'])->name('personnel.supprimer');

Route::get('/personnel/fiche/{id}', [PersonnelController::class, 'fiche'])->name('personnel.fiche');
Route::get('/personnel/fiche/telecharger-document/{id}', [PersonnelController::class, 'TelechargerDocument'])->name('document.telecharger');
Route::get('/personnel/fiche/telecharger-contrat/{id}', [PersonnelController::class, 'TelechargerContrat'])->name('contrats.telecharger');

Route::post('/personnel/{id}/choisir-financement', [PersonnelController::class, 'choisirFinancement'])->name('personnel.choisir.financement');





Route::get('/drh/types-sanctions', [SanctionController::class, 'TypeSanctions'])->name('typesanctions.index');
Route::post('/type-sanction/store', [SanctionController::class, 'store'])->name('typeSanction.store');

Route::get('/modifier-sanction/{id}', [SanctionController::class, 'modifierSanction'])->name('modifierSanction');

Route::post('/modifier-sanction/{id}', [SanctionController::class, 'modifierSanction'])->name('modifierSanction');
Route::post('/Supprimertypesanction/{id}', [SanctionController::class, 'SupprimerTypeSanction'])->name('supprimertypesanction');

Route::get('/sanctions', [SanctionController::class, 'Sanctions'])->name('sanctions.index');
Route::post('/sanctions', [SanctionController::class, 'storeSanctions'])->name('sanction.store');
Route::post('/modifier-sanctions/{id}', [SanctionController::class, 'modifierSanctions'])->name('modifierSanctions');


Route::get('/listePostes', [PosteController::class, 'index'])->name('listePostes');
Route::post('/listePostes/store', [PosteController::class, 'store'])->name('listePostes.store');
Route::post('/modifier-poste/{id}', [PosteController::class, 'modifierPoste'])->name('modifierPoste');
Route::post('/Supprimerposte/{id}', [PosteController::class, 'Supprimerposte'])->name('Supprimerposte');



Route::get('/scanner-presence/{code_qr}', [PresenceController::class, 'scannerQr']);


Route::get('/fiche-paie', [GestionDePaieController::class, 'fiche'])->name('fiche.paie');
Route::get('/Paiement-employe', [GestionDePaieController::class, 'Paiement'])->name('Paiement.employe');



Route::post('/paiement/store', [GestionDePaieController::class, 'store'])->name('paiement.store');
// web.php
Route::get('/imprimer-bulletin/{id}', [GestionDePaieController::class, 'imprimer'])->name('imprimer.bulletin');



Route::get('/liste-documents', [DocumentController::class, 'liste'])->name('listeDocuments');
Route::post('/documents/ajouter', [DocumentController::class, 'ajouter'])->name('documents.ajouter');
Route::get('/personnel/{id}/documents/json', [DocumentController::class, 'documentsParPersonnel']);
Route::get('/documents/{id}/telecharger', [DocumentController::class, 'telecharger'])->name('documents.telecharger');
Route::post('/documents/{id}/supprimer', [DocumentController::class, 'supprimer'])->name('documents.supprimer');
Route::get('/documents/modifier/{id}', [DocumentController::class, 'show']);
Route::post('/documents/modifier', [DocumentController::class, 'update'])->name('documents.update');



Route::get('/liste-contrats', [ContratController::class, 'index'])->name('listeContrats');
Route::post('/contrats/store', [ContratController::class, 'store'])->name('contrats.store');

Route::put('/contrats/{contrat}', [ContratController::class, 'update'])->name('contrats.update');

Route::get('/contrats/{personnel}', [ContratController::class, 'showByPersonnel'])->name('contrats.showByPersonnel');Route::post('/contrats/{id}/changer-statut', [ContratController::class, 'changerStatut']);
Route::post('/contrats/{id}/changer-statut', [ContratController::class, 'changerStatut']);

Route::get('/contrats/{contrat}/edit', [ContratController::class, 'edit'])->name('contrats.edit');
Route::post('/contrats/{id}/renouveler-identique', [ContratController::class, 'renouvelerIdentique']);
Route::post('/contrats/{id}/renouveler', [ContratController::class, 'renouveler'])->name('contrats.renouveler');
Route::post('/contrats/{id}/renouveler-personnalise', [ContratController::class, 'renouvelerPersonnalise'])->name('contrats.renouvelerPersonnalise');


Route::post('/primes/store', [PrimeController::class, 'store'])->name('primes.store');
Route::put('/prime/{id}', [PrimeController::class, 'update'])->name('prime.update');
Route::post('/prime/{id}/etat', [PrimeController::class, 'changerEtat'])->name('prime.changerEtat');

Route::post('/remunerations/store', [RemunerationController::class, 'store'])->name('remunerations.store');
Route::post('/remunerations/update/{id}', [RemunerationController::class, 'update'])->name('remunerations.update');

Route::post('/retenue/store', [RetenueController::class, 'store'])->name('retenue.store');
Route::put('/retenue/{id}', [RetenueController::class, 'update'])->name('retenue.update');
Route::post('/retenue/{id}/etat', [RetenueController::class, 'changerEtat'])->name('retenue.changerEtat');






Route::get('/liste-presences', [PointageController::class, 'listePresence'])->name('liste.presences');
Route::get('/personnel/{id}/statistiques', [PointageController::class, 'statistiques'])->name('personnel.stats');


Route::get('/statistiques-globales', [PointageController::class, 'statistiquesGlobales']);
Route::get('/Courbe-statistiques-globales', [PointageController::class, 'RapportGraphique'])->name('Courbestatistiques');
Route::get('/classement-absences', [PointageController::class, 'classementAbsences']);
Route::get('/taux-globaux', [PointageController::class, 'tauxGlobaux'])->name('taux.globaux');
Route::get('/top-ponctuels', [PointageController::class, 'topPonctuels'])->name('pointage.topPonctuels');
Route::get('/statistiques-hebdomadaires', [PointageController::class, 'statistiquesHebdomadaires']);




});

Route::get('/pointage', [PointageController::class, 'index'])->name('pointage.form');
Route::post('/pointage', [PointageController::class, 'enregistrerPointage'])->name('pointage.enregistrer');


Route::get('/demander', [DemandeController::class,'Demandepage'])->name('demande');


Route::post('/demande-emploi', [DemandeEmploiController::class, 'store'])->name('demande.emploi.store');

//----------------- Ressources Humaines



