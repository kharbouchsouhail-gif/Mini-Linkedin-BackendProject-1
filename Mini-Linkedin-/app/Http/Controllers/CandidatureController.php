<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CandidatureController extends Controller
{


    public function store(Request $request, Offre $offre)
    {
        # dans la param il ya Offre $offre il fait (SELECT * FROM offres WHERE id = ? ($offre))
        $request->validate([
            'profil_id' => 'required|exists:profils,id',
            'message' => 'nullable|string'
        ]);

        $candidature = Candidature::create([
            'offre_id' => $offre->id,
            'profil_id' => $request->profil_id,
            'message' => $request->message,
            'statut' => 'en_attente'
        ]);

        return response()->json($candidature);
    }

    public function myApplications(Request $request)
    {
        $candidatures = Candidature::where('profil_id', $request->profil_id)
            ->with('offre')
            ->get();

        return response()->json($candidatures);
    }

    public function offreCandidatures(Offre $offre)
    {
        # dans la param il ya Offre $offre il fait (SELECT * FROM offres WHERE id = ? ($offre))
        return response()->json(
            $offre->candidatures()->with('profil')->get()
        );
    }

    public function updateStatus(Request $request, Candidature $candidature)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,acceptee,refusee'
        ]);

        $candidature->update([
            'statut' => $request->statut
        ]);

        return response()->json($candidature);
    }
}
