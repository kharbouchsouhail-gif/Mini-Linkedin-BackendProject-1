<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidature>
 */
class CandidatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'offre_id' => \App\Models\Offre::factory(),
        'profil_id' => \App\Models\Profil::factory(),
        'message' => fake()->paragraph(),
        'statut' => 'en_attente',
    ];
}
}
