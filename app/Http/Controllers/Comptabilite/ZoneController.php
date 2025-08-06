<?php

namespace App\Http\Controllers\Comptabilite;

use App\Http\Requests\ZoneRequest;
use App\Repositories\Interfaces\ZoneRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ZoneController extends Controller
{
    protected ZoneRepositoryInterface $zoneRepository;

    public function __construct(ZoneRepositoryInterface $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $zones = $this->zoneRepository->all();
            return response()->json($zones);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des zones.'], 500);
        }
    }

    public function store(ZoneRequest $request): JsonResponse
    {
        try {
            $zone = $this->zoneRepository->create($request->validated());
            return response()->json([
                'message' => 'Zone créée avec succès.',
                'data' => $zone
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création de la zone.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $zone = $this->zoneRepository->find($id);
            if (!$zone) {
                return response()->json(['message' => 'Zone non trouvée.'], 404);
            }
            return response()->json($zone);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de la zone.'], 500);
        }
    }

    public function update(ZoneRequest $request, $id): JsonResponse
    {
        try {
            $zone = $this->zoneRepository->update($id, $request->validated());
            return response()->json([
                'message' => 'Zone mise à jour avec succès.',
                'data' => $zone
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Zone non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour de la zone.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->zoneRepository->delete($id);
            return response()->json(['message' => 'Zone supprimée avec succès.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Zone non trouvée.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression de la zone.'], 500);
        }
    }
}
