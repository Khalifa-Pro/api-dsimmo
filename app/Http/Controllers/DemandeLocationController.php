<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeLocation;
use App\Models\Appartement;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class DemandeLocationController extends Controller
{
    /***
     * Demande de location
     */
    public function creerDemandeLocation(Request $request, $idAppartement)
    {
        \Log::info('Début de la méthode creerDemandeLocation.');

        // Valider les données entrantes
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
        ]);

        \Log::info('Requête validée avec succès : ', $request->all());

        // Créer le client
        $client = Client::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'email' => $request->email,
        ]);

        \Log::info('Client créé avec succès : ', $client->toArray());

        // Récupérer l'appartement à partir de l'ID passé dans l'URL
        $appartement = Appartement::find($idAppartement);  // Correctement importé maintenant

        if (!$appartement) {
            return response()->json(['message' => 'Appartement non trouvé'], 404);
        }

        \Log::info('Appartement récupéré avec succès : ', $appartement->toArray());

        // Créer la demande de location
        $demandeLocation = DemandeLocation::create([
            'client_id' => $client->id,
            'user_id' => $appartement->user_id,
            'appartement_id' => $appartement->id,
            'etat_validation' => 'en attente',
            'mensualite' => $appartement->prix,
            'paiement' => false,
        ]);

        \Log::info('Demande de location créée avec succès : ', $demandeLocation->toArray());

        // Retourner une réponse JSON
        return response()->json(['message' => 'Demande de location créée avec succès', 'demandeLocation' => $demandeLocation], 201);
    }

    /**
     * Accepter demande
     */
    public function accepterDemande($idDemande)
    {
        $demande = DemandeLocation::find($idDemande);

        if (!$demande) {
            return response()->json(['message' => 'Demande non trouvée'], 404);
        }

        // Récupérer l'appartement lié à la demande
        $appartement = Appartement::find($demande->appartement_id);

        if (!$appartement) {
            return response()->json(['message' => 'Appartement non trouvé'], 404);
        }

        // Mettre à jour l'état de la demande et la disponibilité de l'appartement
        $demande->etat_validation = 'accepte';
        $demande->save();

        $appartement->disponibilite = false;
        $appartement->save();

        return response()->json(['message' => 'Demande acceptée avec succès']);
    }

    /**
     * Liste de demandes de locations
     */

     public function listeDemandesEnAttente()
     {
         $demandes = DB::table('demande_locations')
             ->join('appartements', 'demande_locations.appartement_id', '=', 'appartements.id')
             ->join('clients', 'demande_locations.client_id', '=', 'clients.id')
             ->where('appartements.disponibilite', true)
             ->where('demande_locations.etat_validation', 'en attente')
             ->select(
                 'clients.nom',
                 'clients.prenom',
                 'clients.adresse',
                 'clients.telephone',
                 'appartements.numero_appartement', // Assurez-vous que ce champ existe
                 'appartements.prix',
                 'demande_locations.etat_validation',
                 'demande_locations.paiement'
             )
             ->get();
     
         return response()->json($demandes);
     }


     /***
      * Liste des demandes acceptées
      */
     public function listeLocationsAcceptees()
     {
         $locations = DB::table('demande_locations')
             ->join('appartements', 'demande_locations.appartement_id', '=', 'appartements.id')
             ->join('clients', 'demande_locations.client_id', '=', 'clients.id')
             ->where('appartements.disponibilite', false)
             ->where('demande_locations.etat_validation', 'accepte')
             ->select(
                 'clients.nom',
                 'clients.prenom',
                 'clients.adresse',
                 'clients.telephone',
                 'appartements.numero_appartement', // Vérifiez ce champ
                 'appartements.prix',
                 'demande_locations.etat_validation',
                 'demande_locations.paiement'
             )
             ->get();
     
         return response()->json($locations);
     }
     
}
