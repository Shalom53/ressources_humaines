<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrancheRequest;
use App\Repositories\Interfaces\TrancheRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class TrancheController extends Controller
{
    protected TrancheRepositoryInterface $trancheRepository;

    public function __construct(TrancheRepositoryInterface $trancheRepository)
    {
        $this->trancheRepository = $trancheRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $tranches = $this->trancheRepository->all();
            return response()->json($tranches);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des tranches.'], 500);
        }
    }

    public function store(TrancheRequest $request): JsonResponse
    {
        try {
            $tranche = $this->trancheRepository->create($request->validated());
            return response()->json([
                'message' => 'Tranche créée avec succès.',
                'data' => $tranche
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création de la tranche.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $tranche = $this->trancheRepository->find($id);
            if (!$tranche) {
                return response()->json(['message' => 'Tranche non trouvée.'], 404);
            }
            return response()->json($tranche);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de la tranche.'], 500);
        }
    }

    public function update(TrancheRequest $request, $id): JsonResponse
    {
        try {
            $tranche = $this->trancheRepository->update($id, $request->validated());
            return response()->json([
                'message' => 'Tranche mise à jour avec succès.',
                'data' => $tranche
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Tranche non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour de la tranche.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->trancheRepository->delete($id);
            return response()->json(['message' => 'Tranche supprimée avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Tranche non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression de la tranche.'], 500);
        }
    }
}
