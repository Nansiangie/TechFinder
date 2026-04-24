<?php

namespace App\Http\Controllers\web;

use App\Models\intervention;
use App\Models\Utilisateur;
use App\Models\Competence;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    private function getFormData()
    {
        return [
            'clients' => Utilisateur::where('role_user', 'client')->get(),
            'techniciens' => Utilisateur::where('role_user', 'technicien')->get(),
            'competences' => Competence::all()
        ];
    }

    public function index()
    {
        $interventions_list = Intervention::with(['client', 'technicien', 'competence'])->paginate(10);
        $formData = $this->getFormData();
        return view('intervention', array_merge(compact('interventions_list'), $formData));
    }

    public function edit(int $code_int)
    {
        $intervention_edit = Intervention::findOrFail($code_int);
        $interventions_list = Intervention::with(['client', 'technicien', 'competence'])->paginate(10);
        $formData = $this->getFormData();
        return view('intervention', array_merge(compact('intervention_edit', 'interventions_list'), $formData));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_int' => 'required|date',
            'description_int' => 'required|string',
            'code_user_client' => 'required|exists:utilisateur,code_user',
            'code_user_tech' => 'required|exists:utilisateur,code_user',
            'code_comp' => 'required|exists:competences,code_comp',
        ]);

        Intervention::create($request->all());
        flash()->success('Intervention planifiée.');
        return redirect()->route('web.interventions.index');
    }

    public function update(Request $request, int $code_int)
    {
        $request->validate([
            'date_int' => 'required|date',
            'description_int' => 'required|string',
            'code_user_client' => 'required|exists:utilisateur,code_user',
            'code_user_tech' => 'required|exists:utilisateur,code_user',
            'code_comp' => 'required|exists:competences,code_comp',
        ]);

        intervention::findOrFail($code_int)->update($request->all());
        flash()->success('Intervention mise à jour.');
        return redirect()->route('web.interventions.index');
    }

    public function destroy(int $code_int)
    {
        intervention::findOrFail($code_int)->delete();
        flash()->error('Intervention annulée.');
        return redirect()->route('web.interventions.index');
    }
}
