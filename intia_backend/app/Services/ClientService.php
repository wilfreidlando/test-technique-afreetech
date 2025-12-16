<?php
namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ClientService
{
    public function getAll()
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Client::with(['succursale', 'assurances']);

        // Si l'utilisateur est de type succursale, filtrer par sa succursale
        if ($user->isSuccursale()) {
            $query->where('succursale_id', $user->succursale_id);
        }

        return $query->get();
    }

    public function getById($id)
    {
        return Client::with(['succursale', 'assurances'])->findOrFail($id);
    }

    public function create(array $data)
    {
        /** @var User $user */
        $user = Auth::user();

        // Si utilisateur succursale, forcer sa propre succursale
        if ($user->isSuccursale()) {
            $data['succursale_id'] = $user->succursale_id;
        }
        
        $data['created_by'] = $user->id;

        return Client::create($data);
    }

    public function update($id, array $data)
    {
        $client = Client::findOrFail($id);

        // Empêcher le changement de succursale
        unset($data['succursale_id']);

        $client->update($data);
        return $client->load(['succursale', 'assurances']);
    }

    public function delete($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return true;
    }
}
