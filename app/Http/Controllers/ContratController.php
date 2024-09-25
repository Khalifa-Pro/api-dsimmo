<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Client;
use App\Models\Appartement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Mail\ContratLocation;


class ContratController extends Controller
{
    // Affiche la liste des contrats avec les infos du propriétaire, de l'appartement et du client
    public function index()
    {
       
    }

    // details contrat d'un app donné

    public function getDetailsContrat($idApp)
    {
        // Log de l'info pour la recherche
        Log::info('Recherche du contrat pour l\'appartement et le propriétaire', [
            'appartement_id' => $idApp,
        ]);

        // Effectuer la requête avec des jointures pour obtenir le contrat et les informations associées
        $contratDetails = DB::table('contrats')
            ->join('appartements', 'contrats.appartement_id', '=', 'appartements.id')
            ->join('users', 'contrats.user_id', '=', 'users.id')
            ->join('demande_locations', 'demande_locations.appartement_id', '=', 'appartements.id')
            ->join('clients', 'demande_locations.client_id', '=', 'clients.id')
            ->select(
                'contrats.numero_contrat',
                'contrats.date_debut',
                'contrats.date_fin',
                'contrats.type',
                'contrats.montant',
                'contrats.estValide',
                'appartements.adresse as adresse_appartement',
                'appartements.prix as prix_appartement',
                'appartements.superficie',
                'appartements.nombre_de_pieces',
                'users.nom as proprietaire_nom',
                'users.prenom as proprietaire_prenom',
                'users.adresse as proprietaire_adresse',
                'clients.nom as client_nom',
                'clients.prenom as client_prenom',
                'clients.email as client_email',
                'clients.telephone as client_telephone'
            )
            ->where('contrats.appartement_id', $idApp)
            ->first();

            //return response()->json($contratDetails, 200);

    }

    // creation contrat
    public function store(Request $request, $idApp, $idProp, $emailCLient)
    {
        // Log du début du processus
        Log::info('Démarrage de la création du contrat', [
            'idApp' => $idApp,
            'idProp' => $idProp,
        ]);

        // Validation des données
        try {
            $validated = $request->validate([
                'numero_contrat' => 'required|unique:contrats',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date',
                'type' => 'required|string',
                'montant' => 'required|numeric'
            ]);
            Log::info('Validation des données réussie', ['validated' => $validated]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la validation des données', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Erreur de validation'], 422);
        }

        // Création du contrat
        try {
            $contrat = Contrat::create([
                'numero_contrat' => $request->input('numero_contrat'),
                'date_debut' => $request->input('date_debut'),
                'date_fin' => $request->input('date_fin'),
                'type' => $request->input('type'),
                'montant' => $request->input('montant'),
                'estValide' => true,
                'appartement_id' => $idApp,
                'user_id' => $idProp,
            ]);
            Log::info('Contrat créé avec succès', ['contrat' => $contrat]);

            // Mise à jour de la disponibilité de l'appartement
            $appartement = Appartement::find($idApp);
            if ($appartement) {
                $appartement->disponibilite = false;
                $appartement->save();
                Log::info('Appartement mis à jour en tant qu\'indisponible', ['appartement' => $appartement]);
            }

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du contrat', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Erreur lors de la création du contrat'], 500);
        }

        $detailsContrat = DB::table('contrats')
            ->join('appartements', 'contrats.appartement_id', '=', 'appartements.id')
            ->join('users', 'contrats.user_id', '=', 'users.id')
            ->join('demande_locations', 'demande_locations.appartement_id', '=', 'appartements.id')
            ->join('clients', 'demande_locations.client_id', '=', 'clients.id')
            ->select(
                'contrats.numero_contrat',
                'contrats.date_debut',
                'contrats.date_fin',
                'contrats.type',
                'contrats.montant',
                'contrats.estValide',
                'appartements.adresse as adresse_appartement',
                'appartements.prix as prix_appartement',
                'appartements.superficie',
                'appartements.nombre_de_pieces',
                'users.nom as proprietaire_nom',
                'users.prenom as proprietaire_prenom',
                'users.adresse as proprietaire_adresse',
                'clients.nom as client_nom',
                'clients.prenom as client_prenom',
                'clients.email as client_email',
                'clients.telephone as client_telephone'
            )
            ->where('contrats.appartement_id', $idApp)
            ->first();

        // Envoyer l'email
        Mail::to($emailCLient)->send(new ContratLocation($detailsContrat));

        return response()->json($detailsContrat, 200);
    }

}
