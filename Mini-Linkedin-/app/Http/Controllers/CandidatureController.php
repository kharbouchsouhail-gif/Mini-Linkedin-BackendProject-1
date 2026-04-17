<?php
namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Offre;
use Illuminate\Http\Request;
use App\Models\Profil;

class CandidatureController extends Controller
{
    public function store(Request $request, Offre $offre)
    {
        $request->validate([
            'message' => 'nullable|string'
        ]);

        $user   = auth('api')->user();
        $profil = Profil::where('user_id', $user->id)->firstOrFail();

        // Prevent duplicate candidature
        $exists = Candidature::where('offre_id', $offre->id)
            ->where('profil_id', $profil->id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Déjà candidaté'], 409);
        }

        $candidature = Candidature::create([
            'offre_id'  => $offre->id,
            'profil_id' => $profil->id,
            'message'   => $request->message,
            'statut'    => 'en_attente'
        ]);

        return response()->json($candidature, 201);
    }

    public function myApplications(Request $request)
    {
        $user   = auth('api')->user();
        $profil = Profil::where('user_id', $user->id)->firstOrFail();

        $candidatures = Candidature::where('profil_id', $profil->id)
            ->with('offre')
            ->get();

        return response()->json($candidatures);
    }

    public function offreCandidatures(Offre $offre)
    {
        return response()->json(
            $offre->candidatures()->with('profil')->get()
        );
    }

    public function updateStatus(Request $request, Candidature $candidature)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,acceptee,refusee'
        ]);

        $candidature->update(['statut' => $request->statut]);

        return response()->json($candidature);
    }
}