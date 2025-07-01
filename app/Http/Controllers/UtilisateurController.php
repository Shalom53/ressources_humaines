<?php


namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUtilisateurRequest;
use App\Http\Requests\UpdateUtilisateurRequest;
use App\Models\Annee;
use App\Repositories\Interfaces\UtilisateurRepositoryInterface;

use App\Types\StatutAnnee;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class UtilisateurController extends Controller
{
    protected UtilisateurRepositoryInterface $utilisateurRepo;

    public function __construct(UtilisateurRepositoryInterface $utilisateurRepo)
    {
        $this->utilisateurRepo = $utilisateurRepo;
    }

// ✅ Afficher la page  des Utilisateurs
    public function add ()
    {

        try {
            $utilisateurs = $this->utilisateurRepo->getListe();
            return view('utilisateur.page', compact('utilisateurs'));
        } catch (\Exception $e) {

            Log::error('Erreur lors de la récupération des utilisateurs : ' . $e->getMessage());

            // 🔙 Redirection ou message d'erreur personnalisé
            return back()->with('error', 'Une erreur est survenue.');
        }


    }

// ✅ Liste des Utilisateurs
    public function index(Request $request): JsonResponse
    {
        try {

            $utilisateurs = $this->utilisateurRepo->getListe();
            return response()->json($utilisateurs);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur serveur lors du chargement de la liste.',
                'details' => $e->getMessage()
            ], 500);
        }
    }



// ✅ Afficher un Utilisateur
    public function show($id): JsonResponse
    {
        try {
            $utilisateur = $this->utilisateurRepo->rechercheUtilisateurById($id);
            return response()->json($utilisateur);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erreur serveur.'], 500);
        }
    }

// ✅ Ajout d un Utilisateur
    public function store(StoreUtilisateurRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $utilisateur = $this->utilisateurRepo->addUtilisateur($validated);
            return response()->json($utilisateur, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erreur de validation.',
                'messages' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création.'], 500);
        }
    }

// ✅ Mise à jour
    public function update(UpdateUtilisateurRequest $request, $id): JsonResponse
    {
        try {
            $validated = $request->validated();
            $utilisateur = $this->utilisateurRepo->updateUtilisateur($id, $validated);
            return response()->json($utilisateur);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Utilisateur  non trouvé.'], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erreur de validation.',
                'messages' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour.'], 500);
        }
    }

// ✅ Suppression (désactivation logique)
    public function destroy($id): JsonResponse
    {
        try {
            $utilisateur = $this->utilisateurRepo->deleteUtilisateur($id);
            return response()->json(['message' => 'Utilisateur Supprimé.', 'Utilisateur' => $utilisateur]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression.'], 500);
        }
    }


// ✅ Fonction de verification de l authentification
    public function login(LoginRequest $request)
    {
        try {
            $login = $request->input('login');
            $mot_passe = $request->input('mot_passe');

            $utilisateur = $this->utilisateurRepo->verifierIdentifiants($login, $mot_passe);

            if (! $utilisateur) {
                return response()->json([
                    'message' => 'Identifiants incorrects ou utilisateur inactif.'
                ], 401);
            }

            // Stocker l'utilisateur dans la session
            Session::put('LoginUser', $utilisateur);

            // Récupérer l’année scolaire en cours
            $anneeEncours = Annee::where('statut_annee', StatutAnnee::OUVERT)->orderBy('id')->first();

            if ($anneeEncours) {
                Session::put('AnneeEncours', $anneeEncours);
            }

            return response()->json([
                'message' => 'Connexion réussie.',
                'utilisateur' => $utilisateur,
                'annee_encours' => $anneeEncours
            ]);

        } catch (\Exception $e) {
            Log::error("Erreur lors de l'authentification : " . $e->getMessage());

            return response()->json([
                'message' => 'Erreur serveur lors de la tentative de connexion.',
                'erreur' => $e->getMessage()
            ], 500);
        }
    }



    public function logout()
    {
        try {
            // Supprimer les clés de session spécifiques
            Session::forget('LoginUser');
            Session::forget('AnneeEncours');

            // Optionnel : supprimer toute la session si nécessaire
          Session::flush();

            // Redirection vers la page de login
            return redirect()->route('login')->with('message', 'Déconnexion réussie.');

        } catch (\Exception $e) {
            Log::error("Erreur lors de la déconnexion : " . $e->getMessage());

            return response()->json([
                'message' => 'Erreur lors de la tentative de déconnexion.',
                'erreur' => $e->getMessage()
            ], 500);
        }
    }


}
