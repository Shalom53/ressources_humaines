<?php

namespace App\Http\Controllers;

use App\Http\Requests\UtilisateurRequest;
use App\Repositories\Interfaces\UtilisateurRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UtilisateurController extends Controller
{
    protected UtilisateurRepositoryInterface $utilisateurRepository;

    public function __construct(UtilisateurRepositoryInterface $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $utilisateurs = $this->utilisateurRepository->all();
            return response()->json($utilisateurs);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des utilisateurs.'], 500);
        }
    }

    public function store(UtilisateurRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            if (!empty($data['mot_passe'])) {
                $data['mot_passe'] = Hash::make($data['mot_passe']);
            }
            $utilisateur = $this->utilisateurRepository->create($data);
            return response()->json([
                'message' => 'Utilisateur créé avec succès.',
                'data' => $utilisateur
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création de l\'utilisateur.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $utilisateur = $this->utilisateurRepository->find($id);
            if (!$utilisateur) {
                return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
            }
            return response()->json($utilisateur);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de l\'utilisateur.'], 500);
        }
    }

    public function update(UtilisateurRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->validated();
            if (!empty($data['mot_passe'])) {
                $data['mot_passe'] = Hash::make($data['mot_passe']);
            }
            $utilisateur = $this->utilisateurRepository->update($id, $data);
            return response()->json([
                'message' => 'Utilisateur mis à jour avec succès.',
                'data' => $utilisateur
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->utilisateurRepository->delete($id);
            return response()->json(['message' => 'Utilisateur supprimé avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression.'], 500);
        }
    }
}
