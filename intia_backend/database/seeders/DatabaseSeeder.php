<?php

namespace Database\Seeders;

use App\Models\Assurance;
use App\Models\Client;
use App\Models\Succursale;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
     public function run(): void
    {
        // Créer les succursales
        $douala = Succursale::create([
            'nom' => 'INTIA Douala',
            'ville' => 'Douala',
            'adresse' => 'Akwa, Rue de la Liberté',
            'telephone' => '+237 233 42 50 60',
            'email' => 'douala@intia.cm',
        ]);

        $yaounde = Succursale::create([
            'nom' => 'INTIA Yaoundé',
            'ville' => 'Yaoundé',
            'adresse' => 'Bastos, Avenue Kennedy',
            'telephone' => '+237 222 23 45 67',
            'email' => 'yaounde@intia.cm',
        ]);

        // Créer l'utilisateur DG
        $dg = User::create([
            'name' => 'Directeur Général',
            'email' => 'dg@intia.cm',
            'password' => Hash::make('password'),
            'role' => 'dg',
            'succursale_id' => null,
        ]);

        // Créer des utilisateurs pour les succursales
        $userDouala = User::create([
            'name' => 'Agent Douala',
            'email' => 'douala@intia.cm',
            'password' => Hash::make('password'),
            'role' => 'succursale',
            'succursale_id' => $douala->id,
        ]);

        $userYaounde = User::create([
            'name' => 'Agent Yaoundé',
            'email' => 'yaounde@intia.cm',
            'password' => Hash::make('password'),
            'role' => 'succursale',
            'succursale_id' => $yaounde->id,
        ]);

    }
}
