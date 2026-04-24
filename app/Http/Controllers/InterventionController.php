<?php

namespace App\Http\Controllers;

use App\Models\intervention;
use Illuminate\Http\Request;

class interventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = intervention::with(['client', 'technicien', 'competence'])->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve intervention',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_int' => 'required|date',
            'description_int' => 'required|string',
            'code_user_client' => 'required|exists:utilisateur,code_user',
            'code_user_tech' => 'required|exists:utilisateur,code_user',
            'code_comp' => 'required|exists:competences,code_comp',
        ]);

        try {
            $data = intervention::create([
                'date_int' => $request->date_int,
                'description_int' => $request->description_int,
                'code_user_client' => $request->code_user_client,
                'code_user_tech' => $request->code_user_tech,
                'code_comp' => $request->code_comp,
            ]);

            return response()->json($data, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create intervention',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $code_int)
    {
        try {
            $data = intervention::with(['client', 'technicien', 'competence'])
                ->findOrFail($code_int);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve intervention',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $code_int)
    {
        $request->validate([
            'date_int' => 'sometimes|date',
            'description_int' => 'sometimes|string',
            'code_user_client' => 'sometimes|exists:utilisateur,code_user',
            'code_user_tech' => 'sometimes|exists:utilisateur,code_user',
            'code_comp' => 'sometimes|exists:competences,code_comp',
        ]);

        try {
            $data = intervention::findOrFail($code_int);

            $data->update($request->only([
                'date_int',
                'description_int',
                'code_user_client',
                'code_user_tech',
                'code_comp'
            ]));

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update intervention',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $code_int)
    {
        try {
            $data = intervention::findOrFail($code_int);
            $data->delete();

            return response()->json([
                'message' => 'intervention deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete intervention',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
