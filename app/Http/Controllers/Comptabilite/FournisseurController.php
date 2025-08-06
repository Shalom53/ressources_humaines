<?php

namespace App\Http\Controllers\Comptabilite;

use App\Http\Requests\FournisseurRequest;
use App\Repositories\Interfaces\FournisseurRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class FournisseurController extends Controller
{
    protected FournisseurRepositoryInterface $fournisseurRepository;

    public function __construct(FournisseurRepositoryInterface $fournisseurRepository)
    {
        $this->fournisseurRepository = $fournisseurRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $fournisseurs = $this->fournisseurRepository->all();
            return response()->json($fournisseurs);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des fournisseurs.'], 500);
        }
    }

    public function store(FournisseurRequest $request): JsonResponse
    {
        try {
            $fournisseur = $this->fournisseurRepository->create($request->validated());
            return response()->json([
                'message' => 'Fournisseur créé avec succès.',
                'data' => $fournisseur
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création du fournisseur.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $fournisseur = $this->fournisseurRepository->find($id);
            if (!$fournisseur) {
                return response()->json(['message' => 'Fournisseur non trouvé.'], 404);
            }
            return response()->json($fournisseur);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération du fournisseur.'], 500);
        }
    }

    public function update(FournisseurRequest $request, $id): JsonResponse
    {
        try {
            $fournisseur = $this->fournisseurRepository->update($id, $request->validated());
            return response()->json([
                'message' => 'Fournisseur mis à jour avec succès.',
                'data' => $fournisseur
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Fournisseur non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour du fournisseur.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->fournisseurRepository->delete($id);
            return response()->json(['message' => 'Fournisseur supprimé avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Fournisseur non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression du fournisseur.'], 500);
        }
    }
}
