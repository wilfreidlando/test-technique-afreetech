<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssuranceRequest;
use App\Http\Requests\UpdateAssuranceRequest;
use App\Models\Assurance;
use App\Services\AssuranceService;
use Illuminate\Http\Request;

class AssuranceController extends Controller
{
    protected $assuranceService;

    public function __construct(AssuranceService $assuranceService)
    {
        $this->assuranceService = $assuranceService;
    }

    public function index()
    {
        $assurances = $this->assuranceService->getAll();

        return response()->json([
            'success' => true,
            'data' => $assurances
        ]);
    }

    public function show($id)
    {
        $assurance = $this->assuranceService->getById($id);
        $this->authorize('view', $assurance);

        return response()->json([
            'success' => true,
            'data' => $assurance
        ]);
    }

    public function store(StoreAssuranceRequest $request)
    {
        $this->authorize('create', Assurance::class);

        $validatedData = $request->all();

        $assurance = $this->assuranceService->create($validatedData);

        return response()->json([
            'success' => true,
            'data' => $assurance->load(['client.succursale']),
            'message' => 'Assurance créée avec succès'
        ], 201);
    }

    public function update(UpdateAssuranceRequest $request, $id)
    {
        $assurance = Assurance::findOrFail($id);
        $this->authorize('update', $assurance);

        $validatedData = $request->all();

        $assurance = $this->assuranceService->update($id, $validatedData);

        return response()->json([
            'success' => true,
            'data' => $assurance,
            'message' => 'Assurance modifiée avec succès'
        ]);
    }

    public function destroy($id)
    {
        $assurance = Assurance::findOrFail($id);
        $this->authorize('delete', $assurance);

        $this->assuranceService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Assurance supprimée avec succès'
        ]);
    }

    public function byClient($clientId)
    {
        $assurances = $this->assuranceService->getByClient($clientId);

        return response()->json([
            'success' => true,
            'data' => $assurances
        ]);
    }
}
