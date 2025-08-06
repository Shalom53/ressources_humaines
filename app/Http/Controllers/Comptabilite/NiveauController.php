<?php

namespace App\Http\Controllers;

use App\Http\Requests\NiveauRequest;
use App\Repositories\Interfaces\NiveauRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class NiveauController extends Controller
{
    protected NiveauRepositoryInterface $niveauRepository;

    public function __construct(NiveauRepositoryInterface $niveauRepository)
    {
        $this->niveauRepository = $niveauRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $niveaux = $this->niveauRepository->all();
            return response()->json($niveaux);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des niveaux.'], 500);
        }
    }

    public function store(NiveauRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $niveau = $this->niveauRepository->create($data);
            return response()->json([
                'message' => 'Niveau créé avec succès.',
                'data' => $niveau
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création du niveau.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $niveau = $this->niveauRepository->find($id);
            if (!$niveau) {
                return response()->json(['message' => 'Niveau non trouvé.'], 404);
            }
            return response()->json($niveau);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération du niveau.'], 500);
        }
    }

    public function update(NiveauRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $niveau = $this->niveauRepository->update($id, $data);
            return response()->json([
                'message' => 'Niveau mis à jour avec succès.',
                'data' => $niveau
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Niveau non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour du niveau.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->niveauRepository->delete($id);
            return response()->json(['message' => 'Niveau supprimé avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Niveau non trouvé.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression du niveau.'], 500);
        }
    }
}
