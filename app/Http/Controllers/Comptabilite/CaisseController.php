<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaisseRequest;
use App\Repositories\Interfaces\CaisseRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CaisseController extends Controller
{
    protected CaisseRepositoryInterface $caisseRepository;

    public function __construct(CaisseRepositoryInterface $caisseRepository)
    {
        $this->caisseRepository = $caisseRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $caisses = $this->caisseRepository->all();
            return response()->json($caisses);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des caisses.'], 500);
        }
    }

    public function store(CaisseRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $caisse = $this->caisseRepository->create($data);
            return response()->json([
                'message' => 'Caisse créée avec succès.',
                'data' => $caisse
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création de la caisse.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $caisse = $this->caisseRepository->find($id);
            if (!$caisse) {
                return response()->json(['message' => 'Caisse non trouvée.'], 404);
            }
            return response()->json($caisse);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de la caisse.'], 500);
        }
    }

    public function update(CaisseRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $caisse = $this->caisseRepository->update($id, $data);
            return response()->json([
                'message' => 'Caisse mise à jour avec succès.',
                'data' => $caisse
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Caisse non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->caisseRepository->delete($id);
            return response()->json(['message' => 'Caisse supprimée avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Caisse non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression.'], 500);
        }
    }
}
