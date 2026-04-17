<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\User; // Assurez-vous d'importer le modèle User


class AdminUserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé']);
    }
}
