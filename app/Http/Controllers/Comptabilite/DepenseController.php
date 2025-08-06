<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepenseRequest;
use App\Repositories\Interfaces\DepenseRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class DepenseController extends Controller
{
    protected DepenseRepositoryInterface $depenseRepository;

    public function __construct(DepenseRepositoryInterface $depenseRepository)
    {
        $this->depenseRepository = $depenseRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $depenses = $this->depenseRepository->all();
            return response()->json($depenses);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des dépenses.'], 500);
        }
    }

    public function store(DepenseRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $depense = $this->depenseRepository->create($data);
            return response()->json([
                'message' => 'Dépense enregistrée avec succès.',
                'data' => $depense
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'enregistrement de la dépense.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $depense = $this->depenseRepository->find($id);
            if (!$depense) {
                return response()->json(['message' => 'Dépense non trouvée.'], 404);
            }
            return response()->json($depense);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de la dépense.'], 500);
        }
    }

    public function update(DepenseRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $depense = $this->depenseRepository->update($id, $data);
            return response()->json([
                'message' => 'Dépense mise à jour avec succès.',
                'data' => $depense
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Dépense non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->depenseRepository->delete($id);
            return response()->json(['message' => 'Dépense supprimée avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Dépense non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression.'], 500);
        }
    }
}
