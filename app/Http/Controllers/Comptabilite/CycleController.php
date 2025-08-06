<?php

namespace App\Http\Controllers;

use App\Http\Requests\CycleRequest;
use App\Repositories\Interfaces\CycleRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CycleController extends Controller
{
    protected CycleRepositoryInterface $cycleRepository;

    public function __construct(CycleRepositoryInterface $cycleRepository)
    {
        $this->cycleRepository = $cycleRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $cycles = $this->cycleRepository->all();
            return response()->json($cycles);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des cycles.'], 500);
        }
    }

    public function store(CycleRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $cycle = $this->cycleRepository->create($data);
            return response()->json([
                'message' => 'Cycle créé avec succès.',
                'data' => $cycle
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création du cycle.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $cycle = $this->cycleRepository->find($id);
            if (!$cycle) {
                return response()->json(['message' => 'Cycle non trouvé.'], 404);
            }
            return response()->json($cycle);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération du cycle.'], 500);
        }
    }

    public function update(CycleRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $cycle = $this->cycleRepository->update($id, $data);
            return response()->json([
                'message' => 'Cycle mis à jour avec succès.',
                'data' => $cycle
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cycle non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour du cycle.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->cycleRepository->delete($id);
            return response()->json(['message' => 'Cycle supprimé avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cycle non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression du cycle.'], 500);
        }
    }
}
