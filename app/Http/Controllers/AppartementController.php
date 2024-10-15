<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartement;
use Illuminate\Support\Facades\File;

class AppartementController extends Controller
{
    /***
     * Ajouter appartement
     */
    public function store(Request $request, $idProprietaire)
    {
        \Log::info('Début de la méthode store pour ajouter un appartement.');

        // Validation des entrées
        $request->validate([
            'prix' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,jfif,png,jpg,gif,svg|max:8120',
            'videos' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000', // Validation pour la vidéo
            'adresse' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'superficie' => 'required|integer',
            'nombre_de_pieces' => 'required|integer',
            'niveau' => 'required|integer',
            'numero_appartement' => 'required|string', // Changement de integer à string pour numéro d'appartement
        ]);

        \Log::info('Requête validée avec succès : ', $request->all());

        // Traitement de l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $nomImage = $image->getClientOriginalName(); // Utilisez le nom original de l'image
            $cheminImage = public_path('/assets/images/appartements');

            \Log::info('Fichier image reçu : ' . $nomImage);

            // Vérifiez si le répertoire existe, sinon créez-le
            if (!File::exists($cheminImage)) {
                File::makeDirectory($cheminImage, 0755, true);
                \Log::info('Répertoire des images créé : ' . $cheminImage);
            }

            // Déplacez l'image dans le répertoire
            $image->move($cheminImage, $nomImage);
            \Log::info('Image déplacée avec succès vers : ' . $cheminImage);
        } else {
            \Log::info('Aucune image reçue dans la requête.');
        }

        // Traitement de la vidéo
        if ($request->hasFile('videos')) {
            $video = $request->file('videos');
            $nomVideo = $video->getClientOriginalName(); // Utilisez le nom original de la vidéo
            $cheminVideo = public_path('/assets/videos/appartements');

            \Log::info('Fichier vidéo reçu : ' . $nomVideo);

            // Vérifiez si le répertoire existe, sinon créez-le
            if (!File::exists($cheminVideo)) {
                File::makeDirectory($cheminVideo, 0755, true);
                \Log::info('Répertoire des vidéos créé : ' . $cheminVideo);
            }

            // Déplacez la vidéo dans le répertoire
            $video->move($cheminVideo, $nomVideo);
            \Log::info('Vidéo déplacée avec succès vers : ' . $cheminVideo);
        } else {
            \Log::info('Aucune vidéo reçue dans la requête.');
        }

        // Créez l'appartement dans la base de données
        $appartement = Appartement::create([
            'prix' => $request->prix,
            'image' => isset($nomImage) ? $nomImage : null,
            'videos' => isset($nomVideo) ? $nomVideo : null,
            'adresse' => $request->adresse,
            'disponibilite' => true, // Par défaut disponible
            'status' => $request->status,
            'superficie' => $request->superficie,
            'nombre_de_pieces' => $request->nombre_de_pieces,
            'niveau' => $request->niveau,
            'numero_appartement' => $request->numero_appartement,
            'description' => $request->description,
            'user_id' => $idProprietaire // Id de l'utilisateur connecté (propriétaire)
        ]);

        \Log::info('Appartement créé avec succès : ', $appartement->toArray());

        // Retournez une réponse JSON
        return response()->json(['message' => 'Appartement créé avec succès'], 201);
    }

    /***
     * Liste des appartements disponibles
     */

     public function getAppartements()
    {
        \Log::info('Récupération des appartements disponibles.');

        // Récupérer les appartements dont la disponibilité est à true
        $appartementsDisponibles = Appartement::where('disponibilite', true)->get();

        // Filtrer pour enlever les redondances d'image
        $appartementsUniques = $appartementsDisponibles->unique('image');

        \Log::info('Appartements disponibles sans redondance d\'images récupérés : ', $appartementsUniques->toArray());

        return response()->json($appartementsUniques->values()->all(), 200);
    }

    // public function getAppartements()
    // {
    //     \Log::info('Récupération des appartements disponibles.');

    //     // Récupérer les appartements dont la disponibilité est à true
    //     $appartementsDisponibles = Appartement::where('disponibilite', true)->get();

    //     \Log::info('Appartements disponibles récupérés : ', $appartementsDisponibles->toArray());

    //     return response()->json($appartementsDisponibles, 200);
    // }

    public function getAllApp(){
        $appartementsDisponibles = Appartement::all();
        return response()->json($appartementsDisponibles, 200);
    }

    /**
     * Appartements d'un prop
     */
    public function getAppartementsByIdProp($proprietaireId)
    {
        \Log::info("Récupération des appartements du propriétaire ID: {$proprietaireId}");

        $appartements = Appartement::where('user_id', $proprietaireId) // Filtrer par l'ID du propriétaire
                                    ->get();

        \Log::info('Appartements disponibles récupérés : ', $appartements->toArray());

        return response()->json($appartements, 200);
    }


    /***
     * Archiver un appartement
     */
    public function archiverAppartement($idProprietaire)
    {
        \Log::info('Archivage de l\'appartement avec l\'ID : ' . $idProprietaire);

        // Rechercher l'appartement par son ID
        $appartement = Appartement::find($idProprietaire);

        if ($appartement) {
            // Mettre la disponibilité à false
            $appartement->disponibilite = false;
            $appartement->save();

            \Log::info('Appartement archivé avec succès : ', $appartement->toArray());

            return response()->json(['message' => 'Appartement archivé avec succès'], 200);
        } else {
            \Log::info('Appartement non trouvé avec l\'ID : ' . $idProprietaire);

            return response()->json(['message' => 'Appartement non trouvé'], 404);
        }
    }

    /***
     * Desarchiver appartement
     */
    public function restaurerAppartement($idProprietaire)
    {
        \Log::info('Désarchivage de l\'appartement avec l\'ID : ' . $idProprietaire);

        // Rechercher l'appartement par son ID
        $appartement = Appartement::find($idProprietaire);

        if ($appartement) {
            // Mettre la disponibilité à true
            $appartement->disponibilite = true;
            $appartement->save();

            \Log::info('Appartement désarchivé avec succès : ', $appartement->toArray());

            return response()->json(['message' => 'Appartement désarchivé avec succès'], 200);
        } else {
            \Log::info('Appartement non trouvé avec l\'ID : ' . $idProprietaire);

            return response()->json(['message' => 'Appartement non trouvé'], 404);
        }
    }

    /***
     * Details appartements Proprietaire
     */
    public function detailsAppartement($idProprietaire)
    {
        \Log::info('Récupération des détails des appartements pour le propriétaire avec l\'ID : ' . $idProprietaire);

        // Récupérer tous les appartements appartenant au propriétaire
        $appartements = Appartement::where('user_id', $idProprietaire)->get();

        if ($appartements->isEmpty()) {
            \Log::info('Aucun appartement trouvé pour le propriétaire avec l\'ID : ' . $idProprietaire);

            return response()->json(['message' => 'Aucun appartement trouvé pour ce propriétaire'], 404);
        }

        \Log::info('Appartements trouvés pour le propriétaire avec l\'ID : ' . $idProprietaire, $appartements->toArray());

        // Retourner les détails des appartements
        return response()->json($appartements, 200);
    }

    public function detailsApp($idAppartement) 
    {
        \Log::info('Récupération des détails de l\'appartement avec l\'ID : ' . $idAppartement);

        // Récupérer les détails de l'appartement avec l'ID donné
        $appartement = Appartement::find($idAppartement);

        if (!$appartement) {
            \Log::info('Aucun appartement trouvé avec l\'ID : ' . $idAppartement);
            return response()->json(['message' => 'Aucun appartement trouvé'], 404);
        }

        \Log::info('Appartement trouvé avec l\'ID : ' . $idAppartement, $appartement->toArray());

        // Retourner les détails de l'appartement
        return response()->json($appartement, 200);
    }


}
