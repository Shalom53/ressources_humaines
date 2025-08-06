<?php

namespace App\Http\Controllers;

use App\Http\Requests\FraisEcoleRequest;
use App\Repositories\Interfaces\FraisEcoleRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class FraisEcoleController extends Controller
{
    protected FraisEcoleRepositoryInterface $fraisEcoleRepository;

    public function __construct(FraisEcoleRepositoryInterface $fraisEcoleRepository)
    {
        $this->fraisEcoleRepository = $fraisEcoleRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $frais = $this->fraisEcoleRepository->all();
            return response()->json($frais);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des frais.'], 500);
        }
    }

    public function store(FraisEcoleRequest $request): JsonResponse
    {
        try {
            $frais = $this->fraisEcoleRepository->create($request->validated());
            return response()->json([
                'message' => 'Frais enregistré avec succès.',
                'data' => $frais
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'enregistrement.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $frais = $this->fraisEcoleRepository->find($id);
            if (!$frais) {
                return response()->json(['message' => 'Frais non trouvé.'], 404);
            }
            return response()->json($frais);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération.'], 500);
        }
    }

    public function update(FraisEcoleRequest $request, $id): JsonResponse
    {
        try {
            $frais = $this->fraisEcoleRepository->update($id, $request->validated());
            return response()->json([
                'message' => 'Frais mis à jour avec succès.',
                'data' => $frais
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Frais non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->fraisEcoleRepository->delete($id);
            return response()->json(['message' => 'Frais supprimé avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Frais non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression.'], 500);
        }
    }
}
