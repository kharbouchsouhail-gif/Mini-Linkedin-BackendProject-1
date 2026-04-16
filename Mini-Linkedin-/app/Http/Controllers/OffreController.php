<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {

    #le model de tableau offre  apple Offre 🚨🚨🚨🚨🚨🚨🚨🚨🚨
    # ===================== sa en relation avec le condudature==================
        $query = Offre::where('actif', true);

        if ($request->localisation) {
            $query->where('localisation', $request->localisation);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $offres = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($offres);
    }

    public function show(Offre $offre)
    {
        return response()->json($offre);
    }


    # ===================sa en relation avec le recruteur ==================
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'titre' => 'required',
            'description' => 'required',
            'localisation' => 'nullable',
            'type' => 'required|in:CDI,CDD,stage'
        ]);

        $offre = Offre::create($request->all());

        return response()->json($offre);
    }

    public function update(Request $request, Offre $offre)
    {
        $offre->update($request->all());
        return response()->json($offre);
    }

    public function destroy(Offre $offre)
    {
        $offre->delete();
        return response()->json(['message' => 'Offre supprimée']);
    }
}
