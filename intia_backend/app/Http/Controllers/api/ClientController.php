<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Models\Client;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        $clients = $this->clientService->getAll();

        return response()->json([
            'success' => true,
            'data' => $clients
        ]);
    }

    public function show($id)
    {
        $client = $this->clientService->getById($id);
        $this->authorize('view', $client);

        return response()->json([
            'success' => true,
            'data' => $client
        ]);
    }

    public function store(StoreClientRequest $request)
    {
        $this->authorize('create', Client::class);

        $validatedData = $request->all();

        $client = $this->clientService->create($validatedData);

        return response()->json([
            'success' => true,
            'data' => $client->load(['succursale', 'assurances']),
            'message' => 'Client créé avec succès'
        ], 201);
    }

    public function update(UpdateClientRequest $request, $id)
    {
        $client = Client::findOrFail($id);
        $this->authorize('update', $client);

        $validatedData = $request->all();

        $client = $this->clientService->update($id, $validatedData);

        return response()->json([
            'success' => true,
            'data' => $client,
            'message' => 'Client modifié avec succès'
        ]);
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $this->authorize('delete', $client);

        $this->clientService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Client supprimé avec succès'
        ]);
    }
}
