<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenteRequest;
use App\Repositories\Interfaces\VenteRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class VenteController extends Controller
{
    protected VenteRepositoryInterface $venteRepository;

    public function __construct(VenteRepositoryInterface $venteRepository)
    {
        $this->venteRepository = $venteRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $ventes = $this->venteRepository->all();
            return response()->json($ventes);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des ventes.'], 500);
        }
    }

    public function store(VenteRequest $request): JsonResponse
    {
        try {
            $vente = $this->venteRepository->create($request->validated());
            return response()->json([
                'message' => 'Vente enregistrée avec succès.',
                'data' => $vente
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'enregistrement de la vente.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $vente = $this->venteRepository->find($id);
            if (!$vente) {
                return response()->json(['message' => 'Vente non trouvée.'], 404);
            }
            return response()->json($vente);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de la vente.'], 500);
        }
    }

    public function update(VenteRequest $request, $id): JsonResponse
    {
        try {
            $vente = $this->venteRepository->update($id, $request->validated());
            return response()->json([
                'message' => 'Vente mise à jour avec succès.',
                'data' => $vente
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Vente non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour de la vente.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->venteRepository->delete($id);
            return response()->json(['message' => 'Vente supprimée avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Vente non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression de la vente.'], 500);
        }
    }
}
