<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'titre' => 'required|string',
            'bio' => 'nullable|string',
            'localisation' => 'nullable|string',
            'disponible' => 'boolean'
        ]);

// abdorahman lmodel smih Profil 🚨🚨🚨🚨🚨🚨🚨🚨🚨🚨

        $exists = Profil::where('user_id', $request->user_id)->first();
        if ($exists) {
            return response()->json(['message' => 'Profil déjà existant'], 409);
        }

        $profil = Profil::create($request->all());

        return response()->json($profil);
    }

    public function show(Request $request)
    {
        $profil = Profil::with('competences')->first(); // simplifié
        return response()->json($profil);
    }

    public function update(Request $request)
    {
        $profil = Profil::where('user_id', $request->user_id)->first();

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
