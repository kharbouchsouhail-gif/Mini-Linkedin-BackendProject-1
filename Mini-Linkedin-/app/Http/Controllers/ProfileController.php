<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profil; // Assurez-vous d'importer le modèle Profil

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titre'        => 'required|string',
            'bio'          => 'nullable|string',
            'localisation' => 'nullable|string',
            'disponible'   => 'boolean'
        ]);

        $user = auth('api')->user(); // ← get user from token

        // Check if profil already exists
        $exists = Profil::where('user_id', $user->id)->first(); // ← use $user->id not $request->user_id
        if ($exists) {
            return response()->json(['message' => 'Profil déjà existant'], 409);
        }

        $profil = Profil::create([
            'user_id'      => $user->id, // ← set it manually from auth
            'titre'        => $request->titre,
            'bio'          => $request->bio,
            'localisation' => $request->localisation,
            'disponible'   => $request->disponible ?? false,
        ]);

        return response()->json($profil, 201);
    }

    public function show(Request $request)
    {
        $user = auth('api')->user();

        $profil = Profil::with('competences')
                        ->where('user_id', $user->id)
                        ->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable.'], 404);
        }

        return response()->json($profil);
    }

    public function update(Request $request)
    {
        $user = auth('api')->user(); // ← match the same guard as store/show

        $profil = Profil::where('user_id', $user->id)->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        $profil->update($request->only([
            'titre',
            'bio',
            'localisation',
            'disponible'
        ]));

        return response()->json($profil);
    }
}
