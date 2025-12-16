<?php

namespace App\Services;

use App\Models\Assurance;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class AssuranceService
{
    public function getAll()
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Assurance::with(['client.succursale']);

        // Si l'utilisateur est de type succursale, filtrer par sa succursale
        if ($user->isSuccursale()) {
            $query->whereHas('client', function($q) use ($user) {
                $q->where('succursale_id', $user->succursale_id);
            });
        }

        return $query->get();
    }

    public function getById($id)
    {
        return Assurance::with(['client.succursale'])->findOrFail($id);
    }

    public function getByClient($clientId)
    {
        return Assurance::where('client_id', $clientId)->get();
    }

    public function create(array $data)
    {
        /** @var User $user */
        $user = Auth::user();

        // Vérifier que le client appartient à la succursale de l'utilisateur
        if ($user->isSuccursale()) {
            $client = Client::findOrFail($data['client_id']);
            if ($client->succursale_id !== $user->succursale_id) {
                throw new \Exception('Client n\'appartient pas à votre succursale');
            }
        }

        // Générer le numéro de contrat si non fourni
        if (empty($data['numero_contrat'])) {
            $data['numero_contrat'] = $this->generateNumeroContrat($data['type']);
        }

        $data['created_by'] = $user->id;

        return Assurance::create($data);
    }

    public function update($id, array $data)
    {
        $assurance = Assurance::findOrFail($id);

        // Empêcher le changement de client_id et numero_contrat
        unset($data['client_id'], $data['numero_contrat']);

        $assurance->update($data);
        return $assurance->load(['client.succursale']);
    }

    public function delete($id)
    {
        $assurance = Assurance::findOrFail($id);
        $assurance->delete();
        return true;
    }
    private function generateNumeroContrat($type)
    {
        $prefix = strtoupper(substr($type, 0, 3));
        $uniqueNumber = str_pad(Assurance::count() + 1, 6, '0', STR_PAD_LEFT);
        return $prefix . '-' . $uniqueNumber;
    }
}
