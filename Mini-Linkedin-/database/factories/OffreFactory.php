<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offre>
 */
class OffreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'titre' => fake()->jobTitle(),
        'description' => fake()->text(),
        'localisation' => fake()->city(),
        'type' => fake()->randomElement(['CDI','CDD','stage']),
        'actif' => true,
    ];
}
}
