<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileCompetenceController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminOffreController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// AUTH (public)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);



// PROTECTED
Route::middleware('auth:api')->group(function () {

    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me',       [AuthController::class, 'me']);


    // OFFRES (any authenticated user can read)
    Route::get('/offres',         [OffreController::class, 'index']);
    Route::get('/offres/{offre}', [OffreController::class, 'show']);


    // CANDIDAT only
    Route::middleware('role:candidat')->group(function () {

        // Profile
        Route::post('/profil', [ProfileController::class, 'store']);
        Route::get('/profil',  [ProfileController::class, 'show']);
        Route::put('/profil',  [ProfileController::class, 'update']);

        // Competences
        Route::post('/profil/competences',                [ProfileCompetenceController::class, 'store']);
        Route::delete('/profil/competences/{competence}', [ProfileCompetenceController::class, 'destroy']);

        // Candidatures
        Route::post('/offres/{offre}/candidature', [CandidatureController::class, 'store']);
        Route::get('/mes-candidatures',           [CandidatureController::class, 'myApplications']);
    });


    // RECRUTEUR only
    Route::middleware('role:recruteur')->group(function () {

        // Offres
        Route::post('/offres',            [OffreController::class, 'store']);
        Route::put('/offres/{offre}',     [OffreController::class, 'update']);
        Route::delete('/offres/{offre}',  [OffreController::class, 'destroy']);

        // Candidatures reçues
        Route::get('/offres/{offre}/candidatures',         [CandidatureController::class, 'offreCandidatures']);
        Route::patch('/candidatures/{candidature}/statut', [CandidatureController::class, 'updateStatus']);
    });


    // ADMIN only
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users',            [AdminUserController::class, 'index']);
        Route::delete('/users/{user}',  [AdminUserController::class, 'destroy']);
        Route::patch('/offres/{offre}', [AdminOffreController::class, 'toggleActive']);
    });
});