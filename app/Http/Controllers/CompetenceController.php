<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Http\Request;


class CompetenceController extends Controller
{
    /**
     * Display a listing of the resource. Il existe les controlleurs api et les controleurs ressources
     */
    public function index() // GET
    {
        try{
            $competences = Competence::all();

            return response()->json($competences, 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to retrieve competence', 'message' => $e->getMessage()], 500);
    }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // POST
    {
             $request->validate([
            'label_comp' => 'required|string|max:255',
            'description_comp' => 'nullable|string'
        ]);

        // Création de la compétence
        try{
            $competence = Competence::create([
            'label_comp' => $request->label_comp,
            'description_comp' => $request->description_comp
        ]);

            return response()->json($competence, 201);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to create competence', 'message' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(int $code_comp) // GET
    {
        try{
           $competence = Competence::findOrFail($code_comp);
           return response()->json($competence, 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to retrieve competence', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $code_comp) // PUT
    {
        // Validation
            $request->validate([
            'label_comp' => 'required|string|max:255',
            'description_comp' => 'nullable|string'
        ]);

        // Mise à jour
        try{
           $competence = Competence::findOrFail($code_comp);
           $competence->update([
            'label_comp' => $request->label_comp,
            'description_comp' => $request->description_comp
           ]);

            return response()->json($competence, 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to update competence', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $code_comp) // DELETE /competences/{id}
    {
        try{
            $competence = Competence::findOrFail($code_comp);
            $competence->delete();
            return response()->json(['message'=> 'Competence deleted successfully'], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Failed to delete competence', 'message' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
{
    $request-> validate([
        'query' => 'required | string | max:255',
    ]);
    try {
        $query = $request -> input('query');
        $competences = Competence::where('label_comp', 'LIKE', "%$query%")
            ->orWhere('description_comp', 'LIKE', "%$query%")
            ->get();

        return response()->json($competences, 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Search failed',
            'message' => $e->getMessage()
        ], 500);
    }
}
}
