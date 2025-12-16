<?php

namespace App\Policies;

use App\Models\Assurance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AssurancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Assurance $assurance): bool
    {
         if ($user->isDG()) {
            return true;
        }

        // Utilisateur succursale peut voir uniquement les assurances de sa succursale
        return $user->succursale_id === $assurance->client->succursale_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
         return $user->isSuccursale();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assurance $assurance): bool
    {
        if ($user->isDG()) {
            return false;
        }

        // Utilisateur succursale peut modifier uniquement les assurances de sa succursale
        return $user->succursale_id === $assurance->client->succursale_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assurance $assurance): bool
    {
         if ($user->isDG()) {
            return false;
        }

        // Utilisateur succursale peut supprimer uniquement les assurances de sa succursale
        return $user->succursale_id === $assurance->client->succursale_id;
    }


}

