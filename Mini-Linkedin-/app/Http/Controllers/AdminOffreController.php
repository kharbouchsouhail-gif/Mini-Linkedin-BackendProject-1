<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offre; // Assurez-vous d'importer le modèle Offre
class AdminOffreController extends Controller
{
    public function toggleActive(Offre $offre)
    {
        $offre->actif = !$offre->actif;
        $offre->save();

        return response()->json($offre);
    }
}
