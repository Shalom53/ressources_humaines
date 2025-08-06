<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnneeRequest;
use App\Repositories\Interfaces\AnneeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class AnneeController extends Controller
{
    protected AnneeRepositoryInterface $anneeRepository;

    public function __construct(AnneeRepositoryInterface $anneeRepository)
    {
        $this->anneeRepository = $anneeRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $annees = $this->anneeRepository->all();
            return response()->json($annees);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du chargement des années.'], 500);
        }
    }

    public function store(AnneeRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $annee = $this->anneeRepository->create($data);
            return response()->json([
                'message' => 'Année créée avec succès.',
                'data' => $annee
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création de l\'année.'], 500);
        }
    }

    public function show($id): JsonR
