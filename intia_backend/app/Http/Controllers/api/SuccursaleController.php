<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuccursaleRequest;
use Illuminate\Http\Request;
use App\Services\SuccursaleService;
use App\Models\Succursale;

class SuccursaleController extends Controller
{
    protected $succursaleService;

    public function __construct(SuccursaleService $succursaleService)
    {
        $this->succursaleService = $succursaleService;
    }

    public function index()
    {
        $succursales = $this->succursaleService->getAll();

        return response()->json([
            'success' => true,
            'data' => $succursales
        ]);
    }

    public function show($id)
    {
        $succursale = $this->succursaleService->getById($id);

        return response()->json([
            'success' => true,
            'data' => $succursale
        ]);
    }

    public function store(StoreSuccursaleRequest $request)
    {
        $this->authorize('create', Succursale::class);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email',
        ]);

        $succursale = $this->succursaleService->create($validated);

        return response()->json([
            'success' => true,
            'data' => $succursale,
            'message' => 'Succursale créée avec succès'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $succursale = Succursale::findOrFail($id);
        $this->authorize('update', $succursale);

        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'ville' => 'sometimes|string|max:100',
            'adresse' => 'sometimes|string',
            'telephone' => 'sometimes|string|max:20',
            'email' => 'sometimes|email',
        ]);

        $succursale = $this->succursaleService->update($id, $validated);

        return response()->json([
            'success' => true,
            'data' => $succursale,
            'message' => 'Succursale modifiée avec succès'
        ]);
    }

    public function destroy($id)
    {
        $succursale = Succursale::findOrFail($id);
        $this->authorize('delete', $succursale);

        $this->succursaleService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Succursale supprimée avec succès'
        ]);
    }
}
