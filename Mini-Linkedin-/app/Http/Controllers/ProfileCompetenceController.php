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
            'profil_id' => 'required|exists:profils,id',
            'competence_id' => 'required|exists:competences,id',
            'niveau' => 'required|in:débutant,intermédiaire,expert'
        ]);

        $profil = Profil::findOrFail($request->profil_id);

        // vérifier si déjà attachée
        $exists = $profil->competences()
            ->where('competence_id', $request->competence_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Compétence déjà ajoutée'
            ], 409);
        }

        // attacher compétence avec pivot (niveau)
        $profil->competences()->attach($request->competence_id, [
            'niveau' => $request->niveau
        ]);

        return response()->json([
            'message' => 'Compétence ajoutée au profil'
        ]);
    }

    public function destroy($competenceId, Request $request)
    {
        $request->validate([
            'profil_id' => 'required|exists:profils,id'
        ]);

        $profil = Profil::findOrFail($request->profil_id);

        $profil->competences()->detach($competenceId);

        return response()->json([
            'message' => 'Compétence supprimée du profil'
        ]);
    }
}
