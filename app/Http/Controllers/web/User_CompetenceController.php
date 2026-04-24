<?php

namespace App\Http\Controllers\web;

use App\Models\User_Competence;
use App\Models\Utilisateur;
use App\Models\Competence;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class User_CompetenceController extends Controller
{
    public function index()
    {
        $affectations = User_Competence::with('utilisateur')->paginate(15);
        // On ne liste que les techniciens, car les clients n'ont pas de compétences
        $techniciens = Utilisateur::where('role_user', 'technicien')->get();
        $competences = Competence::all();

        return view('user_competence', compact('affectations', 'techniciens', 'competences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_user' => 'required|exists:utilisateur,code_user',
            'code_comp' => 'required|exists:competences,code_comp',
        ]);

        // Vérifier si l'affectation existe déjà
        $exists = User_Competence::where('code_user', $request->code_user)
                                 ->where('code_comp', $request->code_comp)
                                 ->exists();

        if ($exists) {
            flash()->warning('Ce technicien possède déjà cette compétence.');
            return redirect()->back();
        }

        User_Competence::create($request->all());
        flash()->success('Compétence affectée au technicien.');
        return redirect()->route('web.user_competences.index');
    }

    public function destroy($code_user, $code_comp)
    {
        User_Competence::where('code_user', $code_user)
                       ->where('code_comp', $code_comp)
                       ->delete();

        flash()->error('Affectation retirée.');
        return redirect()->route('web.user_competences.index');
    }
}
