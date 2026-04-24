<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UtilisateurSeeder::class,
            CompetenceSeeder::class,
        ]);


        $this->call([
            User_CompetenceSeeder::class,
        ]);

        $this->call([
            InterventionSeeder::class,
        ]);
    }
}
