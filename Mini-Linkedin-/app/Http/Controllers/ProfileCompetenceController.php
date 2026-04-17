<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Profil;
use App\Models\Competence;

class ProfileCompetenceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'competence_id' => 'required|exists:competences,id',
            'niveau'        => 'required|in:débutant,intermédiaire,expert'
        ]);

        $user   = auth('api')->user();
        $profil = Profil::where('user_id', $user->id)->firstOrFail();

        $exists = $profil->competences()
            ->wherePivot('competence_id', $request->competence_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Compétence déjà ajoutée'], 409);
        }

        $profil->competences()->attach($request->competence_id, [
            'niveau' => $request->niveau
        ]);

        return response()->json(['message' => 'Compétence ajoutée']);
    }

    public function destroy($competenceId, Request $request)
    {
        $user   = auth('api')->user();
        $profil = Profil::where('user_id', $user->id)->firstOrFail();

        $profil->competences()->detach($competenceId);

        return response()->json(['message' => 'Compétence retirée']);
    }
}
