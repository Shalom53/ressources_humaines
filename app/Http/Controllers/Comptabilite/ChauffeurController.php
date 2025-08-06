<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChauffeurRequest;
use App\Repositories\Interfaces\ChauffeurRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ChauffeurController extends Controller
{
    protected ChauffeurRepositoryInterface $chauffeurRepository;

    public function __construct(ChauffeurRepositoryInterface $chauffeurRepository)
    {
        $this->chauffeurRepository = $chauffeurRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $chauffeurs = $this->chauffeurRepository->all();
            return response()->json($chauffeurs);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des chauffeurs.'], 500);
        }
    }

    public function store(ChauffeurRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $chauffeur = $this->chauffeurRepository->create($data);
            return response()->json([
                'message' => 'Chauffeur créé avec succès.',
                'data' => $chauffeur
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création du chauffeur.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $chauffeur = $this->chauffeurRepository->find($id);
            if (!$chauffeur) {
                return response()->json(['message' => 'Chauffeur non trouvé.'], 404);
            }
            return response()->json($chauffeur);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération du chauffeur.'], 500);
        }
    }

    public function update(ChauffeurRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $chauffeur = $this->chauffeurRepository->update($id, $data);
            return response()->json([
                'message' => 'Chauffeur mis à jour avec succès.',
                'data' => $chauffeur
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Chauffeur non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour du chauffeur.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->chauffeurRepository->delete($id);
            return response()->json(['message' => 'Chauffeur supprimé avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Chauffeur non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression du chauffeur.'], 500);
        }
    }
}
