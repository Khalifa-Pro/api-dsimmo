<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
/***
 * AUTHENTIFICATION API
 */
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');

/***
 * ===============================================
 * UTILISATEUR
 * ===============================================
 */
     // Routes pour la gestion des utilisateurs
     Route::get('users', [\App\Http\Controllers\UserController::class, 'listUsers']);
     Route::post('users/activer/{id}', [\App\Http\Controllers\UserController::class, 'activerUser']);
     Route::post('users/desactiver/{id}', [\App\Http\Controllers\UserController::class, 'desactiverUser']);


/***
 * ==============================================
 * BIEN IMMOBILIER API
 * ==============================================
 */
    /**
     * APPARTEMENTS API
     */
    Route::get('details-appartement/{idProprietaire}',[\App\Http\Controllers\AppartementController::class,'detailsAppartement']);
    Route::post('ajouter-appartement/{idProprietaire}',[\App\Http\Controllers\AppartementController::class,'store']);
    Route::get('/appartements/disponibles', [\App\Http\Controllers\AppartementController::class, 'getAppartements']);
    Route::post('/appartement/archive/{idProprietaire}', [\App\Http\Controllers\AppartementController::class, 'archiverAppartement']);
    Route::post('/appartement/restaurer/{idProprietaire}', [\App\Http\Controllers\AppartementController::class, 'restaurerAppartement']);

/***
 * =================================================
 * DEMANDE DE LOCATIONS
 * =================================================
 */
    Route::post('demande-location/{idAppartement}', [\App\Http\Controllers\DemandeLocationController::class, 'creerDemandeLocation']);
    Route::get('/demandes-en-attente', [\App\Http\Controllers\DemandeLocationController::class, 'listeDemandesEnAttente']);
    Route::get('/locations-acceptees', [\App\Http\Controllers\DemandeLocationController::class, 'listeLocationsAcceptees']);
    Route::post('/accepter-demande/{id}', [\App\Http\Controllers\DemandeLocationController::class, 'accepterDemande']);
