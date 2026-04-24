<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() // GET
    {
        try{
            $utilisateurs = Utilisateur::all();
            return response()->json($utilisateurs, 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to retrieve utilisateurs', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code_user' => 'required|string|max:255|unique:utilisateur,code_user',
            'nom_user' => 'required|string|max:255',
            'prenom_user' => 'required|string|max:255',
            'login_user' => 'required|string|max:255|unique:utilisateur,login_user',
            'password_user' => 'required|string|min:8',
            'tel_user' => 'required|string|max:20',
            'sexe_user' => 'required|in:M,F',
            'role_user' => 'sometimes|in:admin,technicien,client',
            'etat_user' => 'sometimes|in:actif,inactif,suspendu',
        ]);
        try{
            $utilisateur = Utilisateur::create($request->all());
            return response()->json($utilisateur, 201);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to create utilisateur', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code_user)
    {
        try{
            $utilisateur = Utilisateur::findOrFail($code_user);
            return response()->json($utilisateur, 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to retrieve utilisateur', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $code_user)
    {
        $request->validate([
            'nom_user' => 'required|string|max:255',
            'prenom_user' => 'required|string|max:255',
            'login_user' => 'required|string|max:255|unique:utilisateur,login_user,'.$code_user.',code_user',
            'password_user' => 'required|string|min:8',
            'tel_user' => 'required|string|max:20',
            'sexe_user' => 'required|in:M,F',
            'role_user' => 'sometimes|in:admin,technicien,client',
            'etat_user' => 'sometimes|in:actif,inactif,suspendu',
        ]);
        try{
            $utilisateur = Utilisateur::findOrFail($code_user);
            $utilisateur->update($request->all());
            return response()->json($utilisateur, 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to update utilisateur', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code_user)
    {
        try{
            $utilisateur = Utilisateur::findOrFail($code_user);
            $utilisateur->delete();
            return response()->json(['message'=>'Utilisateur deleted successfully'], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to delete utilisateur', 'message' => $e->getMessage()], 500);
        }
    }
}
