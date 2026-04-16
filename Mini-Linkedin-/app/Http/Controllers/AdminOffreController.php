<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminOffreController extends Controller
{
    public function toggleActive(Offre $offre)
    {
        $offre->actif = !$offre->actif;
        $offre->save();

        return response()->json($offre);
    }
}
