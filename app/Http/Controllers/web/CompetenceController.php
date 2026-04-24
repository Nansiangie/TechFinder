<?php

namespace App\Http\Controllers\web;

use App\Models\Competence;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    /**
     * Affiche la liste et le formulaire d'ajout (Mode Création)
     */
    public function index()
    {
        // On affiche 8 compétences par page
        $competences_list = Competence::paginate(15);
        return view('competence', compact('competences_list'));
    }

    /**
     * Redirige vers l'index car on n'utilise pas de page séparée pour la création
     */
    public function create()
    {
        return redirect()->route('web.competences.index');
    }

    /**
     * Affiche une compétence spécifique
     */
    public function show(string $code_comp)
    {
        $competence = Competence::findOrFail($code_comp);
        return view('competence', compact('competence'));
    }

    /**
     * Prépare la vue pour la modification (Mode Édition)
     */
    public function edit(string $code_comp)
    {
        $competence_edit = Competence::findOrFail($code_comp);

        // Important : Il faut aussi paginer ici pour que la liste reste cohérente
        $competences_list = Competence::paginate(15);

        return view('competence', compact('competence_edit', 'competences_list'));
    }

    /**
     * Enregistre une nouvelle compétence
     */

    public function store(Request $request)
    {
        $request->validate([
            'label_comp' => 'required|string|max:255',
            'description_comp' => 'nullable|string'
        ]);

        Competence::create($request->all());

        // Utilisation de Flasher avant la redirection
        flash()->addSuccess('Compétence ajoutée avec succès.');

        return redirect()->route('web.competences.index');
    }

      /**
     * Met à jour la compétence en base de données
     */

    public function update(Request $request, string $code_comp)
    {
        $request->validate([
            'label_comp' => 'required|string|max:255',
            'description_comp' => 'nullable|string'
        ]);

        $competence = Competence::findOrFail($code_comp);
        $competence->update([
            'label_comp' => $request->label_comp,
            'description_comp' => $request->description_comp
        ]);

        // Utilisation de Flasher
        flash()->addSuccess('Compétence mise à jour.');

        return redirect()->route('web.competences.index');
    }

     /**
     * Supprime la compétence
     */

    public function destroy(string $code_comp)
    {
        $competence = Competence::findOrFail($code_comp);
        $competence->delete();

        // Notification de suppression (tu peux utiliser ->error() ou ->warning() pour varier)
        flash()->addInfo('La compétence a été supprimée définitivement.');

        return redirect()->route('web.competences.index');
    }
}
