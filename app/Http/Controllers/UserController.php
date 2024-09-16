<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /***
     * Liste des utilisateurs
     */
    public function listUsers()
    {
        // Récupère les utilisateurs avec les colonnes souhaitées
        $users = User::select('nom', 'prenom', 'email', 'telephone', 'profil')->get();

        return response()->json($users, 200);
    }

    /***
     * Activer utilisateur
     */
    public function activerUser($id)
    {
        // Trouver l'utilisateur par son ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        // Activer l'utilisateur
        $user->etat = 'ACTIVER';
        $user->save();

        return response()->json(['message' => 'Utilisateur activé avec succès'], 200);
    }

    /***
     * Desactiver utilisateur
     */
    public function desactiverUser($id)
    {
        // Trouver l'utilisateur par son ID
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        // Désactiver l'utilisateur
        $user->etat = 'DESACTIVER';
        $user->save();

        return response()->json(['message' => 'Utilisateur désactivé avec succès'], 200);
    }


}
