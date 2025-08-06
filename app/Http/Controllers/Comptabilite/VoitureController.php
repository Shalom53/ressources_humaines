<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoitureRequest;
use App\Repositories\Interfaces\VoitureRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class VoitureController extends Controller
{
    protected VoitureRepositoryInterface $voitureRepository;

    public function __construct(VoitureRepositoryInterface $voitureRepository)
    {
        $this->voitureRepository = $voitureRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $voitures = $this->voitureRepository->all();
            return response()->json($voitures);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des voitures.'], 500);
        }
    }

    public function store(VoitureRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $voiture = $this->voitureRepository->create($data);
            return response()->json([
                'message' => 'Voiture enregistrée avec succès.',
                'data' => $voiture
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'enregistrement de la voiture.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $voiture = $this->voitureRepository->find($id);
            if (!$voiture) {
                return response()->json(['message' => 'Voiture non trouvée.'], 404);
            }
            return response()->json($voiture);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de la voiture.'], 500);
        }
    }

    public function update(VoitureRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $voiture = $this->voitureRepository->update($id, $data);
            return response()->json([
                'message' => 'Voiture mise à jour avec succès.',
                'data' => $voiture
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Voiture non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour de la voiture.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->voitureRepository->delete($id);
            return response()->json(['message' => 'Voiture supprimée avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Voiture non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression de la voiture.'], 500);
        }
    }
}
