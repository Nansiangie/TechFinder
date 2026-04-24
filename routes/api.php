<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\User_CompetenceController;

// Routes CRUD
Route::apiResource('competences', CompetenceController::class); //cree toutes les routes
Route::apiResource('utilisateurs', UtilisateurController::class);

Route::apiResource('interventions', InterventionController::class);

Route::apiResource('user-competences', User_CompetenceController::class);

// Route recherche
Route::get('competences/search', [CompetenceController::class, 'search']);


