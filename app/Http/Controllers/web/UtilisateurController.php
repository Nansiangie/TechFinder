<?php

namespace App\Http\Controllers\web;

use App\Models\Utilisateur;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    public function index()
    {
        $utilisateurs_list = Utilisateur::paginate(10);
        return view('utilisateur', compact('utilisateurs_list'));
    }

    public function edit(string $code_user)
    {
        $utilisateur_edit = Utilisateur::findOrFail($code_user);
        $utilisateurs_list = Utilisateur::paginate(10);
        return view('utilisateur', compact('utilisateur_edit', 'utilisateurs_list'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_user' => 'required|string|unique:utilisateur,code_user',
            'nom_user' => 'required|string|max:255',
            'prenom_user' => 'required|string|max:255',
            'login_user' => 'required|string|unique:utilisateur,login_user',
            'password_user' => 'required|string|min:8',
            'tel_user' => 'required|string|max:20',
            'sexe_user' => 'required|in:M,F',
            'role_user' => 'required|in:admin,technicien,client',
            'etat_user' => 'required|in:actif,inactif,suspendu',
        ]);

        Utilisateur::create($request->all());
        flash()->success('Utilisateur créé avec succès.');
        return redirect()->route('web.utilisateurs.index');
    }

    public function update(Request $request, string $code_user)
    {
        $request->validate([
            'nom_user' => 'required|string|max:255',
            'prenom_user' => 'required|string|max:255',
            'login_user' => 'required|string|unique:utilisateur,login_user,'.$code_user.',code_user',
            'tel_user' => 'required|string|max:20',
            'sexe_user' => 'required|in:M,F',
            'role_user' => 'required|in:admin,technicien,client',
            'etat_user' => 'required|in:actif,inactif,suspendu',
        ]);

        $utilisateur = Utilisateur::findOrFail($code_user);

        $data = $request->except(['password_user', 'code_user']);
        // On ne met à jour le mot de passe que s'il est rempli dans le formulaire
        if ($request->filled('password_user')) {
            $data['password_user'] = $request->password_user;
        }

        $utilisateur->update($data);
        flash()->success('Utilisateur mis à jour.');
        return redirect()->route('web.utilisateurs.index');
    }

    public function destroy(string $code_user)
    {
        Utilisateur::findOrFail($code_user)->delete();
        flash()->error('Utilisateur supprimé.');
        return redirect()->route('web.utilisateurs.index');
    }
}
