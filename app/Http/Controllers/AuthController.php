<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /***
     * Registrer
     */
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'profil' => 'required|string',
            'etat' => 'required|string',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'profil' => $request->profil,
            'etat' => 'ACTIVE',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    /***
     * Login
     */
    public function login(Request $request)
    {
        // Validation des informations de connexion
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Tentative de connexion
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        // Récupérer l'utilisateur après la connexion réussie
        $user = User::where('username', $request->username)->firstOrFail();

        // Vérification du rôle de l'utilisateur
        if (!in_array($user->profil, ['PROPRIETAIRE', 'AGENT', 'ADMIN'])) {
            return response()->json(['message' => 'Access denied: invalid user role'], 403);
        }

        // Création du token d'authentification
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retourner la réponse avec le token et le rôle
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user_role' => $user->profil,
        ]);
    }

    /***
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
