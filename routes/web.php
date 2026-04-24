<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\CompetenceController;
use App\Http\Controllers\web\UtilisateurController;
use App\Http\Controllers\web\InterventionController;
use App\Http\Controllers\web\User_CompetenceController;

// On redirige l'accueil directement vers les compétences (plus besoin de login pour l'instant)
Route::get('/', function () {
    return redirect()->route('web.competences.index');
});

// Tes anciennes routes de login (laissées au cas où pour plus tard)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- TOUTES LES ROUTES SONT MAINTENANT LIBRES (Plus de middleware auth) ---

// --- ROUTES UTILISATEURS ---
Route::get('/web/utilisateur', [UtilisateurController::class, 'index'])->name('web.utilisateurs.index');
Route::post('/web/utilisateur', [UtilisateurController::class, 'store'])->name('web.utilisateurs.store');
Route::get('/web/utilisateur/{code_user}/edit', [UtilisateurController::class, 'edit'])->name('web.utilisateurs.edit');
Route::put('/web/utilisateur/{code_user}', [UtilisateurController::class, 'update'])->name('web.utilisateurs.update');
Route::delete('/web/utilisateur/{code_user}', [UtilisateurController::class, 'destroy'])->name('web.utilisateurs.destroy');

// --- ROUTES COMPETENCES ---
Route::get('/web/competence', [CompetenceController::class, 'index'])->name('web.competences.index');
Route::post('/web/competence', [CompetenceController::class, 'store'])->name('web.competences.store');
Route::get('/web/competence/{code_comp}/edit', [CompetenceController::class, 'edit'])->name('web.competences.edit');
Route::put('/web/competence/{code_comp}', [CompetenceController::class, 'update'])->name('web.competences.update');
Route::delete('/web/competence/{code_comp}', [CompetenceController::class, 'destroy'])->name('web.competences.destroy');

// --- ROUTES INTERVENTIONS ---
Route::get('/web/intervention', [InterventionController::class, 'index'])->name('web.interventions.index');
Route::post('/web/intervention', [InterventionController::class, 'store'])->name('web.interventions.store');
Route::get('/web/intervention/{code_int}/edit', [InterventionController::class, 'edit'])->name('web.interventions.edit');
Route::put('/web/intervention/{code_int}', [InterventionController::class, 'update'])->name('web.interventions.update');
Route::delete('/web/intervention/{code_int}', [InterventionController::class, 'destroy'])->name('web.interventions.destroy');

// --- ROUTES USER_COMPETENCE ---
Route::get('/web/user_competences', [User_CompetenceController::class, 'index'])->name('web.user_competences.index');
Route::post('/web/user_competences', [User_CompetenceController::class, 'store'])->name('web.user_competences.store');
Route::delete('/web/user_competences/{code_user}/{code_comp}', [User_CompetenceController::class, 'destroy'])->name('web.user_competences.destroy');
