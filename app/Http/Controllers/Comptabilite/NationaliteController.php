<?php

namespace App\Http\Controllers;

use App\Http\Requests\NationaliteRequest;
use App\Repositories\Interfaces\NationaliteRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class NationaliteController extends Controller
{
    protected NationaliteRepositoryInterface $nationaliteRepository;

    public function __construct(NationaliteRepositoryInterface $nationaliteRepository)
    {
        $this->nationaliteRepository = $nationaliteRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $nationalites = $this->nationaliteRepository->all();
            return response()->json($nationalites);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des nationalités.'], 500);
        }
    }

    public function store(NationaliteRequest $request): JsonResponse
    {
        try {
            $nationalite = $this->nationaliteRepository->create($request->validated());
            return response()->json([
                'message' => 'Nationalité créée avec succès.',
                'data' => $nationalite
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création de la nationalité.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $nationalite = $this->nationaliteRepository->find($id);
            if (!$nationalite) {
                return response()->json(['message' => 'Nationalité non trouvée.'], 404);
            }
            return response()->json($nationalite);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de la nationalité.'], 500);
        }
    }

    public function update(NationaliteRequest $request, $id): JsonResponse
    {
        try {
            $nationalite = $this->nationaliteRepository->update($id, $request->validated());
            return response()->json([
                'message' => 'Nationalité mise à jour avec succès.',
                'data' => $nationalite
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Nationalité non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour de la nationalité.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->nationaliteRepository->delete($id);
            return response()->json(['message' => 'Nationalité supprimée avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Nationalité non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression de la nationalité.'], 500);
        }
    }
}
