<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Intervention::with(['client', 'technicien', 'competence'])->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve interventions',
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
            'code_user_client' => 'required|exists:utilisateurs,code_user',
            'code_user_tech' => 'required|exists:utilisateurs,code_user',
            'code_comp' => 'required|exists:competences,code_comp',
        ]);

        try {
            $data = Intervention::create([
                'date_int' => $request->date_interv,
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
    public function show(int $code_interv)
    {
        try {
            $data = Intervention::with(['client', 'technicien', 'competence'])
                ->findOrFail($code_interv);

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
    public function update(Request $request, int $code_interv)
    {
        $request->validate([
            'date_int' => 'sometimes|date',
            'description_int' => 'sometimes|string',
            'code_user_client' => 'sometimes|exists:utilisateurs,code_user',
            'code_user_tech' => 'sometimes|exists:utilisateurs,code_user',
            'code_comp' => 'sometimes|exists:competences,code_comp',
        ]);

        try {
            $data = Intervention::findOrFail($code_interv);

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
    public function destroy(int $code_interv)
    {
        try {
            $data = Intervention::findOrFail($code_interv);
            $data->delete();

            return response()->json([
                'message' => 'Intervention deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete intervention',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
