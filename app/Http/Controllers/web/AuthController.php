<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Affiche la page de connexion
    public function showLoginForm()
    {
        return view('login');
    }

    // Traite la soumission du formulaire
    public function login(Request $request)
    {
        // 1. Validation des champs
        $request->validate([
            'login_user' => 'required|string',
            'password_user' => 'required|string',
        ]);

        // 2. On cherche l'utilisateur MANUELLEMENT dans la base de données
        $user = \App\Models\Utilisateur::where('login_user', $request->login_user)->first();

        // 3. On vérifie si l'utilisateur existe ET si le mot de passe correspond au hachage
        if ($user && \Illuminate\Support\Facades\Hash::check($request->password_user, $user->password_user)) {

            // 4. CONNEXION FORCÉE : On donne directement l'objet Utilisateur à Laravel
            Auth::login($user);

            // On force l'écriture du cookie
            session()->save();

            // 5. Redirection vers les données
            return redirect()->route('web.competences.index');
        }

        // Si ça échoue (utilisateur non trouvé ou mauvais mot de passe)
        return back()->withErrors([
            'login_user' => 'Les identifiants fournis sont incorrects.',
        ])->onlyInput('login_user');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        flash()->info('Vous avez été déconnecté.');
        return redirect()->route('login');
    }
}
