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
     // Routes pour la gestion des utilisateurs - ADMIN[ACCESS-ALL]
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
     * 
     */
    /*** CLIENT[ACCESS]  ***/
    Route::get('details-appartement/{idProprietaire}',[\App\Http\Controllers\AppartementController::class,'detailsAppartement']);

    /*** CLIENT[ACCESS]  ***/
    Route::get('/appartement/{id}', [\App\Http\Controllers\AppartementController::class, 'detailsApp']);
    
    /*** PROPRIETAIRE[ACCESS]  ***/
    Route::post('ajouter-appartement/{idProprietaire}',[\App\Http\Controllers\AppartementController::class,'store']);
    
    /*** CLIENT[ACCES] & PROPRIETAIRE[ACCESS]  ***/
    Route::get('/appartements/{proprietaireId}', [\App\Http\Controllers\AppartementController::class, 'getAppartementsByIdProp']);
    
    /*** CLIENT[ACCES] & PROPRIETAIRE[ACCESS]  ***/
    Route::get('/disponibles', [\App\Http\Controllers\AppartementController::class, 'getAppartements']);
    Route::get('/defeant-app', [\App\Http\Controllers\AppartementController::class, 'getAllApp']);
    

    /*** PROPRIETAIRE[ACCESS]  ***/
    Route::post('/appartement/archive/{idProprietaire}', [\App\Http\Controllers\AppartementController::class, 'archiverAppartement']);
        
    /*** PROPRIETAIRE[ACCESS]  ***/
    Route::post('/appartement/restaurer/{idProprietaire}', [\App\Http\Controllers\AppartementController::class, 'restaurerAppartement']);

/***
 * =================================================
 * DEMANDE DE LOCATIONS
 * =================================================
 */
     /*** CLIENT[ACCESS]  ***/
    Route::post('demande-location/{idAppartement}', [\App\Http\Controllers\DemandeLocationController::class, 'creerDemandeLocation']);
    
     /*** AGENT[ACCESS]  ***/
    Route::get('/demandes-en-attente', [\App\Http\Controllers\DemandeLocationController::class, 'listeDemandesEnAttente']);
    
     /*** AGENT[ACCESS]  ***/
    Route::get('/demandes-acceptees', [\App\Http\Controllers\DemandeLocationController::class, 'listeDemandesAcceptees']);

     /*** AGENT[ACCESS]  ***/
    Route::get('/locations-acceptees', [\App\Http\Controllers\DemandeLocationController::class, 'listeLocationsAcceptees']);

    /*** AGENT[ACCESS]  ***/
    Route::get('/details-demande-location/{id}', [\App\Http\Controllers\DemandeLocationController::class, 'detailsDemandeLocation']);
    
     /*** PROP[ACCESS]  ***/
    Route::get('demandes-attente/{proprietaireId}', [\App\Http\Controllers\DemandeLocationController::class, 'DemandesEnAttente']);
    
    /*** PROP[ACCESS]  ***/
    Route::get('demandes-acceptees/{proprietaireId}', [\App\Http\Controllers\DemandeLocationController::class, 'DemandesAcceptees']);
    
    
    /*** AGENT[ACCESS]  ***/
    Route::post('/accepter-demande/{id}', [\App\Http\Controllers\DemandeLocationController::class, 'accepterDemande']);

     /*** AGENT[ACCESS]  ***/
    Route::get('/demandes/nombres', [\App\Http\Controllers\DemandeLocationController::class, 'nombreDemandes']); // Pour la réponse combinée


    
/***
 * =================================================
 * CONTRAT
 * =================================================
 */
     /*** AGENT[ACCESS]  ***/    
    Route::post('/creer-contrat/{idApp}/{idProp}/{emailClient}', [\App\Http\Controllers\ContratController::class, 'store']);
    Route::get('/contrats', [\App\Http\Controllers\ContratController::class, 'index']);
    Route::get('/contrat/details/{idApp}', [\App\Http\Controllers\ContratController::class, 'getDetailsContrat']);
