<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Utilisateur>
 */
class UtilisateurFactory extends Factory
{
    public function definition(): array
    {
        return [
            // On passe à 8 chiffres pour avoir 100 millions de combinaisons possibles
            'code_user'     => $this->faker->unique()->numerify('USR-########'),
            'nom_user'      => $this->faker->lastName(),
            'prenom_user'   => $this->faker->firstName(),
            'login_user'    => $this->faker->unique()->userName(),
            'password_user' => bcrypt('password'), // Ou 'admin123' si tu veux un mot de passe en clair à hacher par ton modèle
            'tel_user'      => $this->faker->phoneNumber(),
            'sexe_user'     => $this->faker->randomElement(['M', 'F']),
            'role_user'     => $this->faker->randomElement(['technicien', 'client']),
            'etat_user'     => $this->faker->randomElement(['actif', 'inactif', 'bloque'])
        ];
    }
}
