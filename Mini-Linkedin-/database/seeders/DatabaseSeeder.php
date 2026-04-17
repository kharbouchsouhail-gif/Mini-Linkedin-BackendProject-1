<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profil;
use App\Models\Offre;
use App\Models\Competence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🟡 2 admins
    $admins = User::factory(2)->create([
        'role' => 'admin'
    ]);

    // 🟡 5 recruiters
    $recruiters = User::factory(5)->create([
        'role' => 'recruteur'
    ]);

    foreach ($recruiters as $recruiter) {

        // 2 to 3 job offers per recruiter
        Offre::factory(rand(2,3))->create([
            'user_id' => $recruiter->id
        ]);
    }

    // 🟡 10 candidates
    $candidates = User::factory(10)->create([
        'role' => 'candidat'
    ]);

    foreach ($candidates as $user) {

        // profile for each candidate
        Profil::create([
            'user_id' => $user->id,
            'titre' => fake()->jobTitle(),
            'bio' => fake()->text(),
            'localisation' => fake()->city(),
            'disponible' => true
        ]);
    }

    // 🟡 competences (optional)
    Competence::factory(10)->create();
    }
}
