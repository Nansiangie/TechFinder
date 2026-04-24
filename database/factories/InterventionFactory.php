<?php

namespace Database\Factories;

use App\Models\Competence;
use App\Models\Utilisateur;
use Illuminate\Container\Util;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Intervention>
 */
class InterventionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code_int' => $this->faker->unique()->randomNumber(8),
            'date_int' => $this->faker->date(),
            'note_int'=>$this ->faker->numberBetween(0, 10),
            'description_int'=>$this->faker->sentence(),
            'code_user_client'=>$this->faker->randomElement(Utilisateur::pluck('code_user')->toArray()),
            'code_user_tech'=>$this->faker->randomElement(Utilisateur::pluck('code_user')->toArray()),
            'code_comp'=>$this->faker->randomElement(Competence::pluck('code_comp')->toArray()),
        ];
    }
}
