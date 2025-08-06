<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClasseRequest;
use App\Repositories\Interfaces\ClasseRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ClasseController extends Controller
{
    protected ClasseRepositoryInterface $classeRepository;

    public function __construct(ClasseRepositoryInterface $classeRepository)
    {
        $this->classeRepository = $classeRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $classes = $this->classeRepository->all();
            return response()->json($classes);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des classes.'], 500);
        }
    }

    public function store(ClasseRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $classe = $this->classeRepository->create($data);
            return response()->json([
                'message' => 'Classe créée avec succès.',
                'data' => $classe
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création de la classe.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $classe = $this->classeRepository->find($id);
            if (!$classe) {
                return response()->json(['message' => 'Classe non trouvée.'], 404);
            }
            return response()->json($classe);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de la classe.'], 500);
        }
    }

    public function update(ClasseRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $classe = $this->classeRepository->update($id, $data);
            return response()->json([
                'message' => 'Classe mise à jour avec succès.',
                'data' => $classe
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Classe non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour de la classe.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->classeRepository->delete($id);
            return response()->json(['message' => 'Classe supprimée avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Classe non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression de la classe.'], 500);
        }
    }
}
